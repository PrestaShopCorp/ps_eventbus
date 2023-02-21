import fetch from "node-fetch";
import express from "express";

import request from "supertest";
import assert from "assert";


/*********** SYNC API MOCK**********************/
async function createSyncApi(){

    const SYNC_API_PORT = 3232;
    
    const syncApi = express();
    syncApi.listen(SYNC_API_PORT, () => {
        console.log(`sync-api running on :${SYNC_API_PORT}`);
    });
    syncApi.get('/job/:jobId', function(req, res) {
        console.log(`request to sync-api jobid = ${req.params.jobId}`);
        res.status(201).end()
    });
}

/*********** PROXY API MOCK **********************/
async function createProxyApi(){

    const PROXY_API_PORT = 3333;
    
    const proxyApi = express();
    proxyApi.listen(PROXY_API_PORT, () => {
        console.log(`proxy-api running on ${PROXY_API_PORT}`);
    });
    proxyApi.post('/upload/:jobId', function(req, res) {
        console.log(`request to proxy-api jobid = ${req.params.jobId}`)
        res.status(201).end()
    });
}

async function getCategories() {
    const response = await fetch('http://prestashop/index.php?fc=module&module=ps_eventbus&controller=apiCategories&limit=5&job_id=12', {
        method: 'GET',
    });
    console.log(response);
   return {status: response.status};
}

async function getHealthCheck() {
    console.log('getHealthCheck')
    const response =  await fetch('http://prestashop/index.php?fc=module&module=ps_eventbus&controller=apiHealthCheck')
    return await response.json();
}

async function checkServer() {
    const syncApi =  await fetch('http://localhost:3232/job/12', {
        method: 'GET',
    })
    console.log('SyncApi => ', syncApi);
    const proxyApi =  await fetch('http://localhost:3333/upload/12', {
        method: 'POST',
    })
    console.log('ProxyApi => ', proxyApi);

}


createSyncApi().then(() => {
    createProxyApi().then(() => {
        checkServer().then( async() => {
            const request = await getCategories()
            console.log(request);
        });
    });
});

/* const healcheck = getHealthCheck().then((response) => {
    console.log(response);
    return response;
}); */

/* const categories =  getCategories().then((response) => {
    console.log(response);
    return response;
}); */

/* request(app)
    .get('http://localhost:8000/index.php?fc=module&module=ps_eventbus&controller=apiCategories&job_id=42&limit=5')
    .expect('Content-Type', /json/)
    .expect('Content-Length', '15')
    .expect(200)
    .end(function(err, res) {
      if (err) throw err;
}); */

export class App{};
