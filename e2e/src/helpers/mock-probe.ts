import { WebSocketSubject } from 'rxjs/webSocket';
import { EMPTY, expand, filter, from, map, Observable, takeUntil, timeout, timer } from 'rxjs';
import R from 'ramda';
import testConfig from './test.config';
import axios, { AxiosResponse } from 'axios';
import { ShopContent } from './shop-contents';

const DEFAULT_OPTIONS = {
    timeout: 500,
};

export type MockProbeOptions = typeof DEFAULT_OPTIONS;
export type MockClientOptions = typeof DEFAULT_OPTIONS;

export type PsEventbusSyncResponse = {
    job_id: string;
    object_type: string;
    syncType: 'full'|'incremental';
    total_objects: number;
    has_remaining_objects: boolean;
    remaining_objects: number;
    md5: string;
    status: boolean;
    httpCode: number;
    body: unknown;
    upload_url: string;
};

export type PsEventbusHealthCheckFullResponse = {
    prestashop_version: string;
    ps_eventbus_version: string;
    ps_accounts_version: string;
    php_version: string;
    shop_id: string;
    ps_account: boolean;
    is_valid_jwt: boolean;
    ps_eventbus: boolean;
    env: {
        EVENT_BUS_PROXY_API_URL: string;
        EVENT_BUS_SYNC_API_URL: string;
        EVENT_BUS_LIVE_SYNC_API_URL: string;
    };
    httpCode: number;
};

export type PsEventbusHealthCheckLiteResponse = {
    ps_account: boolean;
    is_valid_jwt: boolean;
    ps_eventbus: boolean;
    env: {
        EVENT_BUS_PROXY_API_URL: string;
        EVENT_BUS_SYNC_API_URL: string;
        EVENT_BUS_LIVE_SYNC_API_URL: string;
    };
    httpCode: number;
};

export type ExplainSqlResponse = {
    '*query': string;
    queryStringified: string;
    httpCode: number;
};

export type PsEventbusSyncUpload = {
    collection: ShopContent;
    id: string;
    properties: unknown;
};

export type MockProbeResponse = {
    apiName: string;
    method: string;
    headers: Record<string, string>;
    url: string;
    query: Record<string, string>;
    params: Record<string, string>;
    body: Record<string, unknown> & { file: PsEventbusSyncUpload[] };
};

let wsConnection: Observable<MockProbeResponse> = null;
function getProbeSocket(): Observable<MockProbeResponse> {
    if (!wsConnection) {
        wsConnection = new WebSocketSubject<MockProbeResponse>('ws://localhost:8080');
    }
    return wsConnection;
}

export function probe(match?: Partial<MockProbeResponse>, options?: MockProbeOptions): Observable<MockProbeResponse> {
    options = R.mergeLeft(options, DEFAULT_OPTIONS);
    const socket = getProbeSocket();

    return socket.pipe(
        filter((message) => (match ? R.whereEq(match, message) : true)),
        takeUntil(timer(options.timeout))
    );
}

export function doFullSync(jobId: string, shopContent: ShopContent, limit: number, options?: MockClientOptions): Observable<PsEventbusSyncResponse> {
    options = R.mergeLeft(options, DEFAULT_OPTIONS);

    const callId = { call_id: Math.random().toString(36).substring(2, 11) };

    const requestNext = (full: number) => {
        return axios.post<PsEventbusSyncResponse>(
            `${testConfig.prestashopUrl}/index.php?fc=module&module=ps_eventbus&controller=apiShopContent&shop_content=${shopContent}&limit=${limit}&full=${full}&job_id=${jobId}`,
            callId,
            {
                headers: {
                    Host: testConfig.prestaShopHostHeader,
                    'Content-Type': 'application/x-www-form-urlencoded', // for compat PHP 5.6
                },
            }
        );
    };

    return from(requestNext(1)).pipe(
        expand((response) => {
            if (response.data.has_remaining_objects) {
                return from(requestNext(0));
            } else {
                return EMPTY;
            }
        }),
        timeout(options.timeout),
        map((response) => response.data)
    );
}

export function callPsEventbus<T>(query: Record<string, string>): Promise<AxiosResponse<T, unknown>> {
    const callId = { call_id: Math.random().toString(36).substring(2, 11) };

    const queryParams = new URLSearchParams(query);
    queryParams.set('fc', 'module');
    queryParams.set('module', 'ps_eventbus');

    return axios.post<T>(`${testConfig.prestashopUrl}/index.php?${queryParams.toString()}`, callId, {
        headers: {
            Host: testConfig.prestaShopHostHeader,
            'Content-Type': 'application/x-www-form-urlencoded', // for compat PHP 5.6
        },
    });
}
