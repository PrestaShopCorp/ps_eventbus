import request from "supertest";

const app = 'http://prestashop';
describe("CategoriesController", () => {
    it("should return 500", async () => {
        await request(app)
        .get('/index.php?fc=module&module=ps_eventbus&controller=apiCategories&job_id=invalid-job-id&limit=5')
        .redirects(1)
        .expect('content-type', /json/)
        .expect(500)
    });
    it("should return 200", async () => {
        await request(app)
        .get('/index.php?fc=module&module=ps_eventbus&controller=apiCategories&job_id=valid-job-id&limit=5')
        .redirects(1)
        .expect('content-type', /json/)
        .expect(200)
    });
   
})