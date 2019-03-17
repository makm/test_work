FROM phpdockerio/php72-fpm:latest

RUN apt-get update

# make install
RUN apt-get -y  install --no-install-recommends build-essential

# Install selected extensions and other stuff
RUN apt-get -y  install --no-install-recommends php-memcached php7.2-mysql php7.2-pgsql php-redis php7.2-bz2 php7.2-gd php-igbinary php-imagick php7.2-mbstring php7.2-soap php-ssh2  php7.2-xsl php-yaml php-xhprof php-xdebug \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*


RUN curl -sL https://deb.nodesource.com/setup_8.x | bash - \
    && apt-get install -y nodejs


## Install Phalcon
#RUN curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | bash \
#    && apt-get install -y php7.1-phalcon \
#    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
#


#set docker-user for 1000 uid
RUN useradd --shell /bin/bash -u 1000 -o -c "" -m docker-user
WORKDIR "/var/www"