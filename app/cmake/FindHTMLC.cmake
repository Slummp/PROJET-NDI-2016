# - Try to find htmlc
# Once done, this will define
#
#    HTMLC_FOUND          = Was htmlc found or not ?
#    HTMLC_VERSION        = The current installed version of htmlc
#    HTMLC_INCLUDE_DIR    = The HTMLC include directory
#    HTMLC_LIBRARY_STATIC = Link this to use HTMLC
#    HTMLC_LIBRARY_SHARED = Link this to use HTMLC
#    HTMLC_EXECUTABLE     = The path to the htmlcc command
#
# If htmlcc is found, the modules defines the following macro
#
#    HTMLC_TARGET(<NAME> <FILE>
#                 [INCLUDE_DIRECTORIES <FILE> [<FILE>...]]
#                 [USE_HEADER <FILE>]
#                 [COMPILE_FLAGS <STRING>]
#                 [VERBOSE])
#
# Copyright (C) 2016 Valentin Lahaye
# This file is part of a free software; you can redistribute it and/or
# modify it under the terms of the GNU Lesser General Public
# License as published by the Free Software Foundation; either
# version 3 of the License, or any later version.
# See the file LISENCE included with this distribution for more
# information.

include(CMakeParseArguments)
include(FindPackageHandleStandardArgs)

find_path(HTMLC_INCLUDE_DIR
  NAMES htmlc.h
  HINTS /usr/include
  /usr/local/include)

find_library(HTMLC_LIBRARY
  NAMES libhtmlc.a
  HINTS /usr/lib
  /usr/local/lib)

find_library(HTMLC_LIBRARY
  NAMES libhtmlc.so
  HINTS /usr/lib
  /usr/local/lib)

# Version detection
if(EXISTS "${HTMLC_INCLUDE_DIR}/htmlc.h")
  file(READ "${HTMLC_INCLUDE_DIR}/htmlc.h" HTMLC_H_CONTENTS)
  string(REGEX MATCH "#define HTMLC_VERSION_TO_STRING[\t ]+\"([0-9.]+)\"" _DUMMY "${HTMLC_H_CONTENTS}")
  set(HTMLC_VERSION ${CMAKE_MATCH_1})
endif()

# The path to the htmlcc command
find_program(HTMLC_EXECUTABLE
  NAMES htmlcc
  PATHS /bin
  /usr/bin
  /usr/local/bin
  DOC "HTMLC compiler (http://github.com/vallahaye/HTMLC)")

mark_as_advanced(HTMLC_INCLUDE_DIR HTMLC_LIBRARY_STATIC HTMLC_LIBRARY_SHARED HTMLC_EXECUTABLE)

# HTMLC_TARGET definition
macro(HTMLC_TARGET NAME INPUT)
  set(HTMLC_TARGET_USAGE "Usage: <name> <file> [USE_HEADER <file>] [INCLUDE_DIRECTORIES <directory> [<directory>...]] [VERBOSE]")

  set(HTMLC_TARGET_INPUT "${INPUT}")
  get_filename_component(HTMLC_TARGET_INPUT_DIRECTORY ${HTMLC_TARGET_INPUT} DIRECTORY)
  if("${HTMLC_TARGET_INPUT_DIRECTORY}" STREQUAL "")
    set(HTMLC_TARGET_INPUT "${CMAKE_CURRENT_SOURCE_DIR}/${INPUT}")
  else()
    get_filename_component(HTMLC_TARGET_INPUT ${HTMLC_TARGET_INPUT} REALPATH)
  endif()
  get_filename_component(HTMLC_TARGET_INPUT_NAME ${HTMLC_TARGET_INPUT} NAME)
  set(HTMLC_TARGET_OUTPUT_SOURCE "${CMAKE_CURRENT_BINARY_DIR}/${HTMLC_TARGET_INPUT_NAME}.c")
  set(HTMLC_TARGET_PARAM_OPTIONS)
  set(HTMLC_TARGET_PARAM_ONE_VALUE_KEY
    USE_HEADER
    COMPILE_FLAGS
    VERBOSE)
  set(HTMLC_TARGET_PARAM_MULTI_VALUE_KEY
    INCLUDE_DIRECTORIES)
  cmake_parse_arguments(HTMLC_TARGET_ARG
    "${HTMLC_TARGET_PARAM_OPTIONS}"
    "${HTMLC_TARGET_PARAM_ONE_VALUE_KEY}"
    "${HTMLC_TARGET_PARAM_MULTI_VALUE_KEY}"
    ${ARGN})
  if(NOT ("${HTMLC_TARGET_ARG_UNPARSED_ARGUMENTS}" STREQUAL ""))
    message(SEND_ERROR ${HTMLC_TARGET_USAGE})
  elseif(NOT ("${HTMLC_TARGET_ARG_VERBOSE}" STREQUAL ""))
    message(SEND_ERROR ${HTMLC_TARGET_USAGE})
  else()
    set(HTMLC_TARGET_COMPILE_FLAGS "")
    separate_arguments(HTMLC_TARGET_ARG_COMPILE_FLAGS)
    list(APPEND HTMLC_TARGET_COMPILE_FLAGS ${HTMLC_TARGET_ARG_COMPILE_FLAGS})
    foreach(DIRECTORY ${HTMLC_TARGET_ARG_INCLUDE_DIRECTORIES})
      list(APPEND HTMLC_TARGET_COMPILE_FLAGS "-I" "${DIRECTORY}")
    endforeach()
    if(NOT ("${HTMLC_TARGET_ARG_USE_HEADER}" STREQUAL ""))
      list(APPEND HTMLC_TARGET_COMPILE_FLAGS "-H" "${HTMLC_TARGET_ARG_USE_HEADER}")
      set(HTMLC_TARGET_OUTPUT_HEADER ${HTMLC_TARGET_ARG_USE_HEADER})
    else()
      set(HTMLC_TARGET_OUTPUT_HEADER "${CMAKE_CURRENT_BINARY_DIR}/views.h")
    endif()
    set(HTMLC_TARGET_ARGS "${ARGN}")
    list(FIND HTMLC_TARGET_ARGS "VERBOSE" HTMLC_TARGET_ARG_VERBOSE_INDEX)
    if(${HTMLC_TARGET_ARG_VERBOSE_INDEX} GREATER -1)
      list(APPEND HTMLC_TARGET_COMPILE_FLAGS "-v")
    endif()
    set(HTMLC_TARGET_OUTPUTS ${HTMLC_TARGET_OUTPUT_SOURCE} ${HTMLC_TARGET_OUTPUT_HEADER})
    add_custom_command(OUTPUT ${HTMLC_TARGET_OUTPUTS}
      COMMAND ${HTMLC_EXECUTABLE}
      ARGS ${HTMLC_TARGET_COMPILE_FLAGS} ${HTMLC_TARGET_INPUT}
      VERBATIM
      DEPENDS ${HTMLC_TARGET_INPUT}
      COMMENT "[HTMLC][${NAME}] Building ${NAME} with htmlcc ${HTMLC_VERSION}"
      WORKING_DIRECTORY ${CMAKE_CURRENT_BINARY_DIR})
    set(HTMLC_VIEW_${NAME}_DEFINED TRUE)
    set(HTMLC_VIEW_${NAME}_INPUT ${HTMLC_TARGET_INPUT})
    set(HTMLC_VIEW_${NAME}_OUTPUTS ${HTMLC_TARGET_OUTPUTS})
    set(HTMLC_VIEW_${NAME}_OUTPUT_SOURCE ${HTMLC_TARGET_OUTPUT_SOURCE})
    set(HTMLC_VIEW_${NAME}_OUTPUT_HEADER ${HTMLC_TARGET_OUTPUT_HEADER})
    set(HTMLC_VIEW_${NAME}_COMPILE_FLAGS ${HTMLC_TARGET_COMPILE_FLAGS})
  endif()
endmacro()

FIND_PACKAGE_HANDLE_STANDARD_ARGS(HTMLC REQUIRED_VARS HTMLC_INCLUDE_DIR HTMLC_LIBRARY HTMLC_EXECUTABLE VERSION_VAR HTMLC_VERSION)
