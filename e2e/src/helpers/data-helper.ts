import R from 'ramda';
import { PsEventbusSyncUpload } from './mock-probe';
import fs from 'fs';
import { Content, shopContentMapping, ShopContent } from './shop-contents';
import axios from 'axios';
import testConfig from './test.config';
import { HealthCheck } from '../type/health-check';
import semver from 'semver';
import hash from 'object-hash';
/**
 * sort upload data by collection and hash to allow easier comparison
 * The hash is calculated from the data object
 *
 * @param data ps_eventbus upload data
 */
export function sortUploadData(data: PsEventbusSyncUpload[]): PsEventbusSyncUpload[] {
    data.forEach((item) => {
        item['hash'] = hash(item);
    });

    return R.pipe(R.sortBy(R.prop('collection')), R.sortBy(R.prop('hash')))(data);
}

export function omitProperties(data: PsEventbusSyncUpload[], omitFields: string[]): PsEventbusSyncUpload[] {
    return data.map((it) => ({
        ...it,
        properties: R.omit(omitFields as never[], it.properties),
    }));
}

export function getControllerContent(shopContent: ShopContent): Content[] {
    return Object.entries(shopContentMapping)
        .filter((it) => it[1] === shopContent)
        .map((it) => it[0]) as Content[];
}

let cachedHealthCheck: HealthCheck = null;

export async function getShopHealthCheck(options?: { cache: boolean }): Promise<HealthCheck> {
    const { cache } = R.mergeLeft(options, { cache: true });
    let healthCheck: HealthCheck;
    if (cache && cachedHealthCheck) {
        healthCheck = cachedHealthCheck;
    } else {
        const res = await axios.get<HealthCheck>(
            `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=apiHealthCheck&job_id=valid-job-healthcheck`
        );
        healthCheck = res.data;
        cachedHealthCheck = healthCheck;
    }
    return healthCheck;
}

const FIXTURE_DIR = './src/fixtures';

export async function loadFixture(shopContent: ShopContent): Promise<PsEventbusSyncUpload[]> {
    const contents = getControllerContent(shopContent);
    const shopVersion = (await getShopHealthCheck()).prestashop_version;
    const shopSemver = semver.coerce(shopVersion);
    const fixture = [];

    const fixtureVersions = await fs.promises.readdir(`${FIXTURE_DIR}`, {
        encoding: 'utf-8',
        withFileTypes: true,
    });

    const availableVersions = fixtureVersions.filter((v) => v.isDirectory()).map((v) => v.name);

    // Cascade from most specific to least specific: patch > minor > major
    // e.g. for 9.1.9: try "9.1.9", then "9.1", then "9"
    const { major, minor, patch } = shopSemver;
    const candidates = [`${major}.${minor}.${patch}`, `${major}.${minor}`, `${major}`];

    const matchingFixture = candidates.find((candidate) => availableVersions.includes(candidate));

    let useFixture = 'latest';

    if (matchingFixture) {
        useFixture = matchingFixture;
    }

    const files = contents.map((content) => fs.promises.readFile(`${FIXTURE_DIR}/${useFixture}/${content}.json`, 'utf-8'));

    for await (const file of files) {
        fixture.push(...JSON.parse(file));
    }
    return fixture;
}
