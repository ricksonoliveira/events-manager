# Events Manager
Manage, Create and Schedule Events. A PHP Laravel back-end challenge.

# CRUD Endpoints:
## Events Routes:
`/api/events{list/ save/ view/ update/ delete/}/{event_id}`

## Organizers Routes:
`/api/organizers/ {list/ save/ view/ update/ delete/}/{organizer_id}`

## Bind Organizers to an Event using following endpoint:
`/api/events/bind/organizers/event/{event_id}` Params: `organizers: [ids]` Type: array

## Unit Tests For Events Endpoints at: `/tests/Unit/EventsTest.php`
