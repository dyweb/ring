# Ring

## Structure

- `Source` represent the source file, a local file (for easier test), a uploaded file
- `Backend` is where file data and meta is stored
- `Meta` is the Meta info for file and images, like `name`, `url`, `size`

**`Output` should be removed

When a file is uploaded 

- construct a `Source` object from the uploaded file
- store data in `Backend`, the internal `storeData` method generate the `Meta` data 
for `storeMeta` to use. ie: you can store file in local filesystem and store `Meta` in
Mysql.
- Meta is then returned to client in json format, ie: a rich text editor got the url for the image it has just
uploaded.