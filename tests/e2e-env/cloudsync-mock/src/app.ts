import fetch from "node-fetch";
import express from "express";

/*********** SYNC API MOCK**********************/
const SYNC_API_PORT = 3232;

const syncApi = express();
syncApi.listen(SYNC_API_PORT, () => {
    console.log(`sync-api running on :${SYNC_API_PORT}`);
});
syncApi.get('/job/:id', function(req, res) {
    console.log(`request to sync-api jobid = ${req.params.id}`)
    switch (req.params.id) {
        case 'valid-job-id':
            res.status(200).end()
            break;
        case 'invalid-job-id':
            res.status(500).end()
            break;
    }       
});

/*********** PROXY API MOCK **********************/
const PROXY_API_PORT = 3333;

const proxyApi =  express();
proxyApi.listen(PROXY_API_PORT, () => {
    console.log(`proxy-api running on ${PROXY_API_PORT}`);
});
proxyApi.post('/upload/:job_id', function(req, res) {
    console.log(`request to proxy-api jobid = ${req.params.job_id}`)
    switch (req.params.job_id) {
        case 'valid-job-id':
            res.status(200).end()
            break;
        case 'invalid-job-id':
            res.status(500).end()
            break;
    }       
});

/* async function getCategories() {
    const response = await fetch('http://prestashop/index.php?fc=module&module=ps_eventbus&controller=apiCategories&limit=5&job_id=valid-job-id', {
        method: 'GET',
    });
    console.log(response);
   return {status: response.status};
}

async function getHealthCheck() {
    console.log('getHealthCheck')
    const response =  await fetch('http://prestashop/index.php?fc=module&module=ps_eventbus&controller=apiHealthCheck', {
        method: 'GET',
    })
    return await response.json();
} */

export class App{};
