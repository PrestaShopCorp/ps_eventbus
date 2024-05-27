//TODO replace bien WSClient Language type

export type Language = {
  active: string;
  date_format_full: string;
  date_format_lite: string;
  id: number;
  is_rtl: string;
  iso_code: string;
  language_code: string;
  locale: string;
  name: string;
};

export const language_en: Partial<Language> = {
  id: 1,
  iso_code: 'en',
};

export const language_fr: Partial<Language> = {
  id: 2,
  iso_code: 'fr',
};
