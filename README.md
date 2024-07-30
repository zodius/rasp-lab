# RASP Lab
透過 hook PHP Opcode Handler 來實作簡單的 PHP RASP!

## Install Dependencies
```bash
    sudo apt-get install build-essential autoconf automake bison flex re2c gdb \
    libtool make pkgconf valgrind git libxml2-dev libsqlite3-dev php-dev
```
## Build example extension
```bash
git clone https://github.com/zodius/rasp-lab.git
cd rasp
phpize
./configure
make -j4

ls "$PWD/modules/rasp.so"
```
## Test your extension
```bash
cd rasp-lab/example
php -d extension="<so絕對路徑>" -S 127.0.0.1:8080
```