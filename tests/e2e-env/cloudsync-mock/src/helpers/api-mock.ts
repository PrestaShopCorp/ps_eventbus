import express from "express";

export async function startSyncApi() {
    const SYNC_API_PORT = 3232;

    const syncApi = express();
    const server = syncApi.listen(SYNC_API_PORT, () => {
        console.log(`sync-api running on :${SYNC_API_PORT}`);
    });

    syncApi.get('/', function(req, res) {
        res.status(200).end()
    });
    syncApi.get('/job/:id', function(req, res) {
        console.log(`request to sync-api jobid = ${req.params.id}`)
        const jobId = req.params.id;

        if(jobId.startsWith('valid-job-')) {
            res.status(201).end()
        } else {
            res.status(500).end()
        }   
    });

    return server;
}

export async function startProxyApi() {

    const PROXY_API_PORT = 3333;
    
    const proxyApi =  express();
    const server = proxyApi.listen(PROXY_API_PORT, () => {
        console.log(`proxy-api running on ${PROXY_API_PORT}`);
    });
    proxyApi.get('/', function(req, res) {
        res.status(200).end()
    });
    proxyApi.post('/upload/:job_id', function(req, res) {
        console.log(`request to proxy-api jobid = ${req.params.job_id}`)
        const jobId = req.params.job_id;

        if(jobId.startsWith('valid-job-')) {
            res.status(201).end()
        } else {
            res.status(500).end()
        }
    });
    
    return server;
}

export default { startSyncApi, startProxyApi}