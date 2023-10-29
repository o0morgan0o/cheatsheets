import type { Config } from 'jest';

export default async (): Promise<Config> => ({
    verbose: true,
    setupFiles: ['<rootDir>/jest.setup.ts'],
});