/* rasp extension for PHP */

#ifdef HAVE_CONFIG_H
# include "config.h"
#endif

#include "php.h"
#include "ext/standard/info.h"
#include "php_rasp.h"
#include "rasp_arginfo.h"

/* For compatibility with older PHP versions */
#ifndef ZEND_PARSE_PARAMETERS_NONE
#define ZEND_PARSE_PARAMETERS_NONE() \
	ZEND_PARSE_PARAMETERS_START(0, 0) \
	ZEND_PARSE_PARAMETERS_END()
#endif

zif_handler original_zend_execute_internal;

/* {{{ Execute command via shell and return complete output as string */
PHP_FUNCTION(hook_shell_exec)
{
	char *command;
	size_t command_len;

	ZEND_PARSE_PARAMETERS_START(1, 1)
		Z_PARAM_STRING(command, command_len)
	ZEND_PARSE_PARAMETERS_END();

	php_printf("Command: %s\n", command);
	printf("Command: %s\n", command);

	if(false) {
		// Call original shell_exec function
		original_zend_execute_internal(INTERNAL_FUNCTION_PARAM_PASSTHRU);
	}
	else {
		// Drop the command
		php_error_docref(NULL, E_WARNING, "Command execution is disabled");
	}
}


int rasp_echo_handler(zend_execute_data *execute_data)
{
	const zend_op *op = execute_data->opline;
	unsigned int op1_type = op->op1_type;

	char *payload = NULL;

	if(op1_type == IS_CONST) {
		// if op1 is constant, we can get the value from the constant table
		if(Z_TYPE_P(RT_CONSTANT(op, op->op1)) == IS_STRING) {
			payload = Z_STRVAL_P(RT_CONSTANT(op, op->op1));
		} else {
			return ZEND_USER_OPCODE_DISPATCH;
		}
	} else if (op1_type == IS_TMP_VAR || op1_type == IS_VAR || op1_type == IS_CV) {
		// if op1 is a variable, we can get the value from the variable table
		zval *z = EX_VAR(op->op1.var);
		if (Z_TYPE_P(z) == IS_STRING) {
			payload = Z_STRVAL_P(z);
		}
	} else {
		// not interested in other types
		php_printf("Not interested in other types\n");
		return ZEND_USER_OPCODE_DISPATCH;
	}

	// do verification here
	printf("Payload: %s\n", payload);

	return ZEND_USER_OPCODE_DISPATCH;
}

/* {{{ void test1() */
PHP_FUNCTION(test1)
{
	ZEND_PARSE_PARAMETERS_NONE();

	php_printf("The extension %s is loaded and working!\r\n", "rasp");
}
/* }}} */

/* {{{ string test2( [ string $var ] ) */
PHP_FUNCTION(test2)
{
	char *var = "World";
	size_t var_len = sizeof("World") - 1;
	zend_string *retval;

	ZEND_PARSE_PARAMETERS_START(0, 1)
		Z_PARAM_OPTIONAL
		Z_PARAM_STRING(var, var_len)
	ZEND_PARSE_PARAMETERS_END();

	retval = strpprintf(0, "Hello %s", var);

	RETURN_STR(retval);
}
/* }}}*/

/* {{{ PHP_MINIT_FUNCTION */
PHP_MINIT_FUNCTION(rasp)
{
	// zend_set_user_opcode_handler(ZEND_ECHO, rasp_echo_handler);
	zend_function *original_function = zend_hash_str_find_ptr(CG(function_table), "shell_exec", sizeof("shell_exec") - 1);
	if(original_function) {
		original_zend_execute_internal = original_function->internal_function.handler;
		original_function->internal_function.handler = PHP_FN(hook_shell_exec);
	}

	return SUCCESS;
}
/* }}} */

/* {{{ PHP_RINIT_FUNCTION */
PHP_RINIT_FUNCTION(rasp)
{
#if defined(ZTS) && defined(COMPILE_DL_RASP)
	ZEND_TSRMLS_CACHE_UPDATE();
#endif

	return SUCCESS;
}
/* }}} */

/* {{{ PHP_MINFO_FUNCTION */
PHP_MINFO_FUNCTION(rasp)
{
	php_info_print_table_start();
	php_info_print_table_row(2, "rasp support", "enabled");
	php_info_print_table_end();
}
/* }}} */

/* {{{ rasp_module_entry */
zend_module_entry rasp_module_entry = {
	STANDARD_MODULE_HEADER,
	"rasp",					/* Extension name */
	ext_functions,					/* zend_function_entry */
	PHP_MINIT(rasp),							/* PHP_MINIT - Module initialization */
	NULL,							/* PHP_MSHUTDOWN - Module shutdown */
	PHP_RINIT(rasp),			/* PHP_RINIT - Request initialization */
	NULL,							/* PHP_RSHUTDOWN - Request shutdown */
	PHP_MINFO(rasp),			/* PHP_MINFO - Module info */
	PHP_RASP_VERSION,		/* Version */
	STANDARD_MODULE_PROPERTIES
};
/* }}} */

#ifdef COMPILE_DL_RASP
# ifdef ZTS
ZEND_TSRMLS_CACHE_DEFINE()
# endif
ZEND_GET_MODULE(rasp)
#endif
