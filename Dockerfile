FROM php:7.4-cli
RUN apt-get update && apt-get install -y git
RUN git clone https://github.com/Tuhinshubhra/RED_HAWK && cp -r RED_HAWK /usr/src/redhawk
WORKDIR /usr/src/redhawk
CMD [ "php", "./rhawk.php", "<<<","$'fix'" ]
CMD [ "php", "./rhawk.php", "<<<","$'update'" ]
CMD [ "php", "./rhawk.php" ]
