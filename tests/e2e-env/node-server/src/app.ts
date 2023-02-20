import fetch from "node-fetch";
import express from "express";

import request from "supertest";
import assert from "assert";

// Constants
const PORT = 8080;
const HOST = '0.0.0.0';

// App
const app = express();
app.get('/', (req, res) => {
  res.send('Hello World');
});
app.listen(PORT, HOST, () => {
    console.log(`Running on http://${HOST}:${PORT}`);
});
app.get('/user', function(req, res) {
    res.status(200).json({ name: 'john' });
  });
  
request(app)
    .get('/user')
    .expect('Content-Type', /json/)
    .expect('Content-Length', '15')
    .expect(200)
    .end(function(err, res) {
      if (err) throw err;
});

/* const req = request('http://localhost:8000');

req.get('/index.php?fc=module&module=ps_eventbus&controller=apiHealthCheck').expect( (res) => {
  console.log(res);
}); */

// ps_eventbus healthcheck
/* const psEventbusHealthcheck = getHealthCheck().then(data => {
    if(data.ps_account) {
        const psApiCategories = getCategories().then(data => {
            console.log(data);
        });
    } else {
        console.log('ps_accounts is down');
        console.log(data)
    }
});

async function getHealthCheck() {
    const response =  await fetch('http://localhost:8000/index.php?fc=module&module=ps_eventbus&controller=apiHealthCheck')
    return response.json();
}

async function getCategories() {
    const response = await fetch('http://localhost:8000/index.php?fc=module&module=ps_eventbus&controller=apiCategories');
    return response.json();
} */

export class App{};