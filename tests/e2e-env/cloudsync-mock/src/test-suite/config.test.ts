export default {
  prestashopUrl:
    process.env.RUN_IN_DOCKER === "1"
      ? "http://prestashop"
      : "http://localhost:8000",
};
