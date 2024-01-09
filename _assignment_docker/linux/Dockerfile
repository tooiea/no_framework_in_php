# OS 使用したいバージョンに合わせて変更
FROM almalinux:9

# dnf updateしてkernelなどを最新化する
RUN dnf update -y \
    && dnf -y install glibc-locale-source glibc-langpack-ja \
    && dnf clean all \
    && rm -rf /var/cache/*

# ロケールと文字コードの設定
# RUN localedef -f UTF-8 -i ja_JP ja_JP.UTF-8
ENV LANG="ja_JP.UTF-8" \
    LANGUAGE="ja_JP:ja" \
    LC_ALL="ja_JP.UTF-8"

# タイムゾーンの設定
RUN ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

# httpd、その他必要なモジュールのインストール
RUN dnf -y install httpd \
    unzip \
    vim \
    wget \
    systemd-sysv \
    && dnf clean all \
    && rm -rf /var/cache/*

# httpd系の設定ファイル配置
COPY ./httpd/conf/httpd.conf /etc/httpd/conf/

# EPEL,remi,phpモジュール
# php、モジュールのインストール、バージョンに合わせて変更
# 使用したいPHPのモジュール(最低限のものだけ)
RUN dnf install -y yum-utils \
    &&  dnf config-manager --set-enabled crb \
    &&  dnf install -y epel-release \
    &&  dnf install -y epel-next-release \
    &&  dnf install -y https://rpms.remirepo.net/enterprise/remi-release-9.rpm \
    &&  dnf module reset -y php \
    &&  dnf module install -y php:remi-8.2 \
    &&  dnf install -y php \
    php-json \
    php-gd \
    php-mbstring \
    php-pdo \
    php-mysqlnd \
    php-pear \
    php-pecl-zip \
    php-intl \
    php-pecl-mcrypt \
    php-devel \
    php-opcache \
    php-bcmath \
    php-pecl-xdebug\
    # phpunitインストール用
    php-cli \
    php-json \
    php-mbstring \
    php-process \
    php-xml \
    php-pecl-pcov \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"\
    && php composer-setup.php\
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer \
    && rm -rf /var/cache/yum/* \
    && yum clean all

# コンテナのプロセスを変更
# Apache MPMをeventからpreforkに変更
RUN sed -i 's/^LoadModule mpm_event_module/#LoadModule mpm_event_module/' /etc/httpd/conf.modules.d/00-mpm.conf \
    && sed -i 's/^#LoadModule mpm_prefork_module/LoadModule mpm_prefork_module/' /etc/httpd/conf.modules.d/00-mpm.conf

RUN curl -sSL https://github.com/mailhog/mhsendmail/releases/download/v0.2.0/mhsendmail_linux_amd64 -o mhsendmail \
    && chmod +x mhsendmail \
    && mv mhsendmail /usr/local/bin/mhsendmail

# php設定ファイル配置
# php-fpm設定内容修正
COPY ./php/php.ini /etc/
COPY ./php/www.conf /etc/php-fpm.d/www.conf

# ポートを公開
EXPOSE 80

WORKDIR /var/www/core

# 緩やかな停止(graceful-stop)
STOPSIGNAL SIGWINCH

# 1プロセスで起動するように修正
CMD ["httpd", "-DFOREGROUND"]
# CMD ["/sbin/init"]