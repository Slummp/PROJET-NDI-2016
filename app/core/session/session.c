#include <ccgi.h>
#include <core/session/session.h>


extern void add_bdd();
extern _Bool exist_in_bdd(int id);

struct session_s {
  _Bool is_new;
  long id;
};

session_t* session_start (HTTP_header_t *header)
{
  session_t* session=malloc(sizeof(*session));
  CGI_varlist* varlist=CGI_get_cookie(NULL);
  CGI_value *varlist=CGI_lookup_all(varlist,
  do{
    session->id=rand();
  }while(!exist_in_bdd(session->id));
}

extern _Bool session_is_new(const session_t *session)
{
  return session->is_new;
}
