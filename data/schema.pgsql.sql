CREATE TABLE public.user_provider
(
  user_id      integer REFERENCES public.user (user_id),
  provider_id  character varying(50) NOT NULL,
  provider     character varying(255) NOT NULL,

PRIMARY KEY (user_id, provider_id),
UNIQUE (provider_id, provider)
);
