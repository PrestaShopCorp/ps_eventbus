import { test as teardown } from '@playwright/test';
import { execSync } from 'child_process';
import path from 'path';

const testTags = ['@teardown'];

teardown('♻️ Restauration de l’état initial de la BDD PrestaShop...', { tag: testTags }, async () => {
  try {
    // Appel à la commande 'make restore' depuis le dossier e2e-env
    execSync('make restore', {
      cwd: path.resolve(__dirname, '../../../../../e2e-env'),
      stdio: 'inherit',
      shell: '/bin/bash' // Utiliser /bin/bash au lieu de /bin/sh
    });
  } catch (error) {
    console.error('❌ Erreur lors de la restauration de la base :', error);
    throw error;
  }
});
