FROM debian:10.0

# Move into root folder
WORKDIR /root/infrastructure

ENV DEBIAN_FRONTEND noninteractive

# Add the debian backports repository in order to get a more recent ansible
RUN apt-get update && apt-get install -myq wget gnupg git make nano

RUN echo 'deb http://ppa.launchpad.net/ansible/ansible/ubuntu focal main' > /etc/apt/sources.list.d/backports.list
RUN apt-key adv --keyserver keyserver.ubuntu.com --recv-keys 93C4A3FD7BB9C367

# Update packages
RUN apt-get -yq update

# Install ansible 
RUN apt-get -yq install python3 python3-pip
RUN python3 -m pip install ansible

RUN apt-get -yq install vim

# Install ansible extension
RUN apt-get -yq install python-dnspython

RUN mkdir /root/.ssh && chmod 0700 /root/.ssh  \
    && ssh-keyscan frozox.fr >> /root/.ssh/known_hosts \
    && ssh-keyscan frozox.fr >> /root/.ssh/known_hosts

# Add the private key and give the correct permission
ADD .provisionner/vault.txt ./vault.txt

ADD .provisionner/key.pem /root/key.pem
RUN chmod 400 /root/key.pem


COPY .infrastructure .

CMD eval `ssh-agent -s` && ssh-add /root/key.pem && chmod -x ./vault.txt && bash
