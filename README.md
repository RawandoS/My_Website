
# My Website

A simple website that uses PHP, javascript and MySQL to create a music album collection, with an admin page where you can receive suggestion from the user (or the admin themselves), and then add them to the database, thanks to the discogs API (only the admin can add an album to the database); a functional login and register pages, that also use another database; every user can login, see all the album in a grid layout with pagination, or in a datatable; each user or admin has the ability to edit evry album, like changing the relase year of an album or even adding the album cover, that will be displayed on the grid page.


## Features

- Fucntional login and Register with session control
- Datatable and grid layout for searching your favourite albums
- Responsive layout
- Reserved admin pages to manage the album database more efficently
- Modify album option to change info about the album or add the cover to the database


## API Reference

#### Get relases with similar name

```http
  GET /api.discogs.com/database/search?q={$query}&type=release
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
|  `query`  | `string` | **Required**. Your API key |

#### Get the album 

```http
  GET /api.discogs.com/releases/{$albumId}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `albumId` |   `int`  | **Required**. Id of item to fetch |


## Authors

- [@RawandoS](https://www.github.com/RawandoS)