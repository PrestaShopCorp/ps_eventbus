import { Category, CategoryWritable } from 'prestashop-ws-client';
import { getLanguageValues } from 'prestashop-ws-client/dist/xml/xml.interfaces';
import { language_en, language_fr } from './langagues';

export const category_home: Partial<Category> = {
  id: 2,
};

export const category_new: CategoryWritable = {
  active: 1,
  additional_description: getLanguageValues(
    {
      id: language_en.id,
      value: 'EN - additional_description',
    },
    {
      id: language_fr.id,
      value: 'FR - description additionnelle',
    },
  ),
  description: getLanguageValues(
    {
      id: language_en.id,
      value: 'EN - additional_description',
    },
    {
      id: language_fr.id,
      value: 'FR - CloudSync Category created description',
    },
  ),
  id: -1, // new
  id_parent: category_home.id,
  is_root_category: 0,
  id_shop_default: '1',
  link_rewrite: getLanguageValues(
    {
      id: language_en.id,
      value: 'EN - link_rewrite',
    },
    {
      id: language_fr.id,
      value: 'FR - link_rewrite',
    },
  ),
  meta_description: getLanguageValues(
    {
      id: language_en.id,
      value: 'EN - meta_description',
    },
    {
      id: language_fr.id,
      value: 'FR - meta_description',
    },
  ),
  meta_keywords: getLanguageValues(
    {
      id: language_en.id,
      value: 'EN - meta_keywords',
    },
    {
      id: language_fr.id,
      value: 'FR - meta_keywords',
    },
  ),
  meta_title: getLanguageValues(
    {
      id: language_en.id,
      value: 'EN - meta_title',
    },
    {
      id: language_fr.id,
      value: 'FR - meta_title',
    },
  ),
  name: getLanguageValues(
    {
      id: language_en.id,
      value: 'EN - Category name',
    },
    {
      id: language_fr.id,
      value: 'FR - nom de catégorie',
    },
  ),
  position: 0,
};

export const categoryMultilanguage: CategoryWritable = {
  id: 4,
  id_parent: 3,
  active: 1,
  id_shop_default: '1',
  is_root_category: 0,
  position: 0,
  name: getLanguageValues(
    { id: 1, value: 'FR-CloudSync' },
    { id: 2, value: 'EN-CloudSync' },
  ),
  link_rewrite: 'CloudSync',
  description: getLanguageValues(
    {
      id: 1,
      value: '<p>FR-CloudSync. </p>',
    },
    {
      id: 2,
      value: '<p>EN-CloudSync. </p>',
    },
  ),
  meta_title: getLanguageValues(
    { id: 1, value: 'FR-CloudSync title' },
    { id: 2, value: 'EN-CloudSync title' },
  ),
  meta_description: getLanguageValues(
    { id: 1, value: 'FR-CloudSync decription' },
    { id: 2, value: 'EN-CloudSync decription' },
  ),
  meta_keywords: getLanguageValues(
    { id: 1, value: 'FR-CloudSync keywords' },
    { id: 2, value: 'EN-CloudSync keywords' },
  ),
  associations: {
    products: [
      {
        id: 1,
      },
    ],
  },
};
