/* rasp extension for PHP */

#ifndef PHP_RASP_H
# define PHP_RASP_H

extern zend_module_entry rasp_module_entry;
# define phpext_rasp_ptr &rasp_module_entry

# define PHP_RASP_VERSION "0.1.0"

# if defined(ZTS) && defined(COMPILE_DL_RASP)
ZEND_TSRMLS_CACHE_EXTERN()
# endif

int rasp_echo_handler(zend_execute_data *execute_data);

#endif	/* PHP_RASP_H */
