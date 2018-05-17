## Build:
```
$ docker image build -t jotbase jotbase
$ docker image build -t jotzone jotzone
$ docker image build -t jotstatic jotstatic
$ docker image build -t loadbalancer loadbalancer
```

## Launch detached
```
$ docker container run -d --name jot -p 81:80 --network docker_default --mount type=bind,src=/webdev/jgivoni/jot/app,dst=/jot/app \
    --mount type=bind,src=/webdev/jgivoni/ophp,dst=/jot/ophp --rm jot
$ docker container run --name redis -d -p 6379:6379 --network docker_default --rm redis:3
```
## Stop detached
```
$ docker container stop jot redis
```
## Launch foreground
```
$ docker container run --name jot -p 81:80 --rm --mount type=bind,src=/webdev/jgivoni/jot/app,dst=/jot/app \
    --mount type=bind,src=/webdev/jgivoni/ophp,dst=/jot/ophp -it jot
```

# Launch and inspect/debug
```
$ docker container run --name jot -p 81:80 --rm --mount type=bind,src=/webdev/jgivoni/jot/app,dst=/jot/app \
    --mount type=bind,src=/webdev/jgivoni/ophp,dst=/jot/ophp -it jot /bin/bash
```

# Launch compose
```
$ docker-compose up
```
# No symlinks on host side!
