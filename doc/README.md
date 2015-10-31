# Ring

## structure

- `Source` represent the source file, a local file (for easier test), a uploaded file
- `Rule` checks if source file matches the requirement
- `Transform` change the file, like  resize image, zip/uzip
- `Backend` is where file data and meta is stored, meta is generated based on source and data storage
- `Meta` is the Meta info for file and images, which can be consumed directly be client, like browser, android app
- `Uploader` connect all the other parts together

## scenario

When a file is uploaded 

- construct a `Source` object from the uploaded file
- it is checked by each `Rule` added to the `Uploader`, throws exception if any of the checks failed.
- store data in `Backend`, the internal `storeData` method generate the `Meta` data 
for `storeMeta` to use. ie: you can store file in local filesystem and store `Meta` in
Mysql.
- Meta is then returned to client in json format, ie: a rich text editor got the url for the image it has just
uploaded.
