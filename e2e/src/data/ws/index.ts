import { CategoryWritable } from 'prestashop-ws-client';
import { getLanguageValues } from 'prestashop-ws-client/dist/xml/xml.interfaces';

export function getWSUrl(): string {
  return '';
}

export function getWSKey(): string {
  return '';
}

export const category_new: CategoryWritable = {
  active: 1,
  additional_description: getLanguageValues(
    { id: 1, value: 'FR - additional description' },
    { id: 2, value: 'EN - additional_description' },
  ),
  description: getLanguageValue(
    LanguagesWSData.LANGUAGES_1.id,
    'CloudSync Category created description',
  ),
  id: '',
  id_parent: CategoriesWsData.HOME_CATEGORY.id,
  is_root_category: '0',
  id_shop_default: '1',
  link_rewrite: getLanguageValue(
    LanguagesWSData.LANGUAGES_1.id,
    'CloudSync Category created link_rewrite',
  ),
  meta_description: getLanguageValue(
    LanguagesWSData.LANGUAGES_1.id,
    'CloudSync category created meta_description',
  ),
  meta_keywords: getLanguageValue(
    LanguagesWSData.LANGUAGES_1.id,
    'CloudSync category created meta_keywords',
  ),
  meta_title: getLanguageValue(
    LanguagesWSData.LANGUAGES_1.id,
    'CloudSync category created meta_title',
  ),
  name: getLanguageValue(
    LanguagesWSData.LANGUAGES_1.id,
    'CloudSync Category created name',
  ),
  position: '0',
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
