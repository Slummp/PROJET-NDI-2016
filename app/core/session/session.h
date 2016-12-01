#ifndef _CORE_SESSION_H
#define _CORE_SESSION_H

#include <core/HTTP/header/header.h>

typedef struct session_s session_t;

/*
  session_start() vérifie si le cookie de session est passé dans
  les headers, si c'est le cas, on vérifie que le sessid existe 
  dans la bdd et on charge la session (on créer une instance de
  la structure session_t avec l'id de la session
  SINON
  On creé un sessid, on vérifie qu'il n'existe pas déjà en bdd,
  puis on le charge dans une structure sessions_t
 */
extern session_t *session_start (HTTP_header_t *header);

/*
  Retourne TRUE si la session a été crée dans lors de ce
  chargement de page
 */
extern _Bool session_is_new (const session_t *session);

extern 

#endif
