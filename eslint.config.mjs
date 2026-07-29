import vue from 'eslint-plugin-vue'
import vueParser from 'vue-eslint-parser'
import prettierConfig from 'eslint-config-prettier'

export default [
  {
    files: ['**/*.vue', '**/*.js'],
    languageOptions: {
      parser: vueParser,
      parserOptions: {
        ecmaVersion: 'latest',
        sourceType: 'module',
      },
      globals: {
        window: true,
        document: true,
        console: true,
        globalThis: true,
      },
    },
    plugins: {
      vue,
    },
    rules: {
      ...vue.configs['flat/recommended'].rules,
      'no-console': 'error',
      'eqeqeq': 'error',
      'no-unused-vars': 'warn',
      'no-duplicate-imports': 'error',
      'vue/eqeqeq': 'error',
      'vue/multi-word-component-names': 'off',
    },
  },
  prettierConfig,
]
