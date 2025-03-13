export function generateFakeJobId(valid = true): string {
    const generatedNumber = Date.now() + Math.trunc(Math.random() * 100000000000000);
    const jobId = `${valid ? 'valid' : 'invalid'}-job-full-${generatedNumber}`;

    return jobId;
}
