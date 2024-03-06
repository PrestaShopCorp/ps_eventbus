import R from "ramda";
import {PsEventbusSyncUpload} from "./mock-probe";
import fs from "fs";
import {Content, contentControllerMapping, Controller} from "./controllers";
import axios from "axios";
import testConfig from "./test.config";
import {HealthCheck} from "../type/health-check";
import semver from "semver/preload";
import {version} from "ts-jest/dist/transformers/hoist-jest";

/**
 * sort upload data by collection and id to allow easier comparison
 * @param data ps_eventbus upload data
 */
export const sortUploadData: (data: PsEventbusSyncUpload[]) => PsEventbusSyncUpload[] = R.pipe(
  R.sortBy(R.prop('collection')),
  R.sortBy(R.prop('id')),
)

/**
 * modules returned by ps_eventbus use their database it as their collection id, which makes it random.
 * this function provides a way to generate a predictable replacement id.
 * @param data
 */
export function generatePredictableModuleId(data: PsEventbusSyncUpload[]): PsEventbusSyncUpload[] {
  return data.map(it => ({...it, id: `${it.properties.name}`}));
}

export function omitProperties(data: PsEventbusSyncUpload[], omitFields: string[]): PsEventbusSyncUpload[] {
  return data.map(it => ({
    ...it,
    properties: R.omit(omitFields, it.properties)
  }))
}

export function getControllerContent(controller: Controller): Content[] {
  return Object.entries(contentControllerMapping)
    .filter(it => it[1] === controller)
    .map(it => it[0]) as Content[];
}

let cachedHealthCheck: HealthCheck = null;

export async function getShopHealthCheck(options?: { cache: boolean }): Promise<HealthCheck> {
  const {cache} = R.mergeLeft(options, {cache: true})
  let healthCheck: HealthCheck;
  if (cache && cachedHealthCheck) {
    healthCheck = cachedHealthCheck;
  } else {
    const res = await axios.get<HealthCheck>(
      `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=apiHealthCheck`
    );
    healthCheck = res.data;
    cachedHealthCheck = healthCheck;
  }
  return healthCheck;
}

const FIXTURE_DIR = './src/fixtures';

export async function loadFixture(controller: Controller): Promise<PsEventbusSyncUpload[]> {
  const contents = getControllerContent(controller);
  const shopVersion = (await getShopHealthCheck()).prestashop_version;
  const fixture = [];

  const fixtureVersions = await fs.promises.readdir(
    `${FIXTURE_DIR}`,
    {encoding: 'utf-8', withFileTypes: true}
  )

  // use either fixture specific to PS version or latest fixture
  const useFixture = fixtureVersions
    .filter(version => version.isDirectory())
    .map(version => version.name)
    .includes(shopVersion) ? shopVersion : 'latest';

  const files = contents.map(content => fs.promises.readFile(
    `${FIXTURE_DIR}/${useFixture}/${controller}/${content}.json`,
    'utf-8'
  ));

  for await (const file of files) {
    fixture.push(...JSON.parse(file))
  }
  return fixture;
}
