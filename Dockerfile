# Image yang akan dipakai untuk running projectnya, dalam hal ini apline adalah OS linux lite
# Bisa menggunakan Image lain yang lebih kecil sizenya
FROM alpine:3.15
LABEL Maintainer="infodatek@setneg.go.id" \
      Description="Lightweight container with Nginx 1.16 & PHP-FPM 7.3 based on Alpine Linux."

# Install packages php fpm dengan RUN, versi ini perlu disesuaikan dengan kebutuhan aplikasinya jika masih versi 5 gunakan php5
RUN apk --no-cache add php7 php7-fpm php7-calendar php7-pdo php7-mysqli php7-pdo_mysql php7-mysqlnd php7-json php7-openssl php7-curl \
    php7-zlib php7-xml php7-simplexml php7-xmlwriter php7-xmlrpc php7-phar php7-intl php7-dom php7-xmlreader php7-ctype php7-session php7-ldap php7-pecl-redis php7-pecl-memcached \
    php7-mbstring php7-gd php7-fileinfo php7-zip php7-bz2 nginx supervisor curl mysql-client

RUN apk --update add wget \ 
		     curl \
		     git \
		     php7-iconv \
		     php7-dom --repository http://nl.alpinelinux.org/alpine/edge/testing/ && rm /var/cache/apk/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer



RUN apk add --no-cache tzdata
ENV TZ Asia/Jakarta

#RUN rm /etc/nginx/conf.d/default.conf

#config service
COPY config/nginx.conf /etc/nginx/nginx.conf
COPY config/fpm-pool.conf /etc/php7/php-fpm.d/www.conf
COPY config/php-config.ini /etc/php7/php.ini
COPY config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# add user dengan spesifik user ID, ID ini yang akan digunakan oleh aplikasi selama running
RUN addgroup -g 1945 -S infotek && adduser -u 1945 -S infotek -G infotek

# Mounting data NFS ke /data ini sudah as user infotek diserver mounting, mounting dilakukan oleh team infra
# RUN mkdir /data-esop

#copy ke nginx folder dan dikasih permission as infotek, copy lalu delete source agar tidak ikut dan jadi lobang hacker
COPY --chown=infotek:infotek src/ /var/www/html
COPY config/config.php /var/www/html/application/config/config.php
COPY config/database.php /var/www/html/application/config/database.php
COPY config/esign.php /var/www/html/application/config/esign.php
COPY config/web_service.php /var/www/html/application/config/web_service.php

#config service harus didelet atau akan terbaca dari website [WARNING]
RUN rm -Rf /var/www/html/nginx.conf
RUN rm -Rf /var/www/html/fpm-pool.conf
RUN rm -Rf /var/www/html/php-config.ini
RUN rm -Rf /var/www/html/supervisord.conf
RUN rm -Rf /var/www/html/config.php
RUN rm -Rf /var/www/html/database.php
RUN rm -Rf /var/www/html/esign.php
RUN rm -Rf /var/www/html/web_service.php
RUN rm -Rf /var/www/html/Dockerfile

RUN chown -R infotek.infotek /run
RUN chown -R infotek.infotek /var/www/html

# Switch to use a non-root user yaitu infotek, penggunaan user nobody dan root tidak aman untuk container
USER infotek

# Docker akan bisa diakses dengan port 8080, yang akan di ambil oleh kubernetes dan diarahkan ke port 443 ssl
EXPOSE 8080

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8081/fpm-ping
