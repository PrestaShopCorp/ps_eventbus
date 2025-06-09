export function generateFakeJobId(valid = true): string {
    const generatedNumber = Date.now() + Math.trunc(Math.random() * 100000000000000);
    const jobId = `${valid ? 'valid' : 'invalid'}-job-full-${generatedNumber}`;

    return jobId;
}

export function colorText(text: string, styles: string[]): string {
  const codes: Record<string, string> = {
    reset: "\x1b[0m",
    bold: "\x1b[1m",
    dim: "\x1b[2m",
    italic: "\x1b[3m",
    underline: "\x1b[4m",
    inverse: "\x1b[7m",
    hidden: "\x1b[8m",
    strikethrough: "\x1b[9m",
    red: "\x1b[31m",
    green: "\x1b[32m",
    yellow: "\x1b[33m",
    blue: "\x1b[34m",
    magenta: "\x1b[35m",
    cyan: "\x1b[36m",
  };
  const start = styles.map(s => codes[s] || "").join("");
  return `${start}${text}${codes.reset}`;
}

