FROM php:latest

RUN apt-get update && apt-get install -y \
    zip \
    zlib1g-dev \
    libzip-dev \
    && docker-php-ext-install zip

#RUN curl -Lo /tmp/glibc-2.31.tar.gz http://ftp.gnu.org/gnu/libc/glibc-2.31.tar.gz \
#    && tar -xvzf /tmp/glibc-2.31.tar.gz -C /tmp/ \
#    && cd /tmp/glibc-2.31 && mkdir build && cd build \
#    && ../configure --prefix=/usr \
#    && make -j$(nproc) \
#    && make install \
#    && rm -rf /tmp/glibc-2.31 /tmp/glibc-2.31.tar.gz

RUN pecl install redis && docker-php-ext-enable redis

CMD ["php", "-S", "0.0.0.0:8000", "-t", "/var/www/html"]
