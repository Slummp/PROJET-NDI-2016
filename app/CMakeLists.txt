cmake_minimum_required(VERSION 2.8)
project(PROJET-NDI-2016)

set(CMAKE_MODULE_PATH ${CMAKE_SOURCE_DIR}/cmake)

find_package(GLIB REQUIRED)
find_package(HTMLC REQUIRED)

if("${CMAKE_BUILD_TYPE}" STREQUAL "")
  set(CMAKE_BUILD_TYPE "RELEASE")
else()
  string(TOUPPER ${CMAKE_BUILD_TYPE} CMAKE_BUILD_TYPE)
endif()

if("${CMAKE_BUILD_TYPE}" STREQUAL "DEBUG")
  set(CMAKE_INSTALL_PREFIX ${PROJECT_BINARY_DIR})
endif()

add_definitions(-std=gnu11
  -Wall
  -Werror
  -Wextra
  -Wshadow
  -Wpointer-arith
  -Wcast-qual
  -Wstrict-prototypes)

include_directories(${PROJECT_SOURCE_DIR} ${GLIB_INCLUDE_DIRS} ${CMAKE_CURRENT_BINARY_DIR})

htmlc_target(ERROR ${CMAKE_CURRENT_SOURCE_DIR}/views/error.htmlc INCLUDE_DIRECTORIES ${CMAKE_CURRENT_SOURCE_DIR}/views)

add_executable(server server.scgi.c
  ${CMAKE_CURRENT_SOURCE_DIR}/core/HTTP/header/header.c
  ${CMAKE_CURRENT_SOURCE_DIR}/core/HTTP/request/method.c
  ${CMAKE_CURRENT_SOURCE_DIR}/hooks/root.c
  ${CMAKE_CURRENT_SOURCE_DIR}/hooks/register.c
  ${HTMLC_VIEW_ERROR_OUTPUT_SOURCE})
 
target_link_libraries(server ccgi ${GLIB_LIBRARIES})
