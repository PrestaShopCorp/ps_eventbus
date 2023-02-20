import request from "supertest";

export default function healthcheckTest(reqUrl) {
    console.log('Start healcheck test')

    reqUrl.get('/index.php?fc=module&module=ps_eventbus&controller=apiHealthCheck').expect(function(res) {
        res.body.httpCode = 500;
        res.body.ps_account = true;
    })
}

