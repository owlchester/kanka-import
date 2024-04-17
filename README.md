# Kanka Import

## Installing

> git checkout
> copy .env.example .env
> sail up

## Running the queue

The importer just accepts a zip and uploads it to the storage and adds and queues a job to the HEAVY queue.

To run the "heavy" queue, go to your kanka directory and run

> sail artisan queue:work --timeout=0 --queue=heavy
