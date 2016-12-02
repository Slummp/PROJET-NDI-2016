#ifndef _APP_CORE_HTTP_HEADER_H
#define _APP_CORE_HTTP_HEADER_H

enum HTTP_header_e {
    ACCESS_CONTROL_ALLOW_ORIGIN,
    ALLOW,
    CACHE_CONTROL,
    CONTENT_DISPOSITION,
    CONTENT_ENCODING,
    CONTENT_LANGUAGE,
    CONTENT_TYPE,
    DATE,
    EXPIRES,
    LAST_MODIFIED,
    LOCATION,
    REFRESH,
    RETRY_AFTER,
    SET_COOKIE,
    STATUS,
    UPGRADE
};

typedef struct HTTP_header_s HTTP_header_t;

extern HTTP_header_t *HTTP_header_create (void);
extern void HTTP_header_destroy (HTTP_header_t *header);
extern const char *HTTP_header_get (const HTTP_header_t *header, enum HTTP_header_e key);
extern int HTTP_header_set (HTTP_header_t *header, enum HTTP_header_e key, const char *value);
extern _Bool HTTP_header_isset (const HTTP_header_t *header, enum HTTP_header_e key);
extern void HTTP_header_send (const HTTP_header_t *header);

#endif
