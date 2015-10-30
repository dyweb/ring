# ring

[![Build Status](https://travis-ci.org/dyweb/ring.svg?branch=master)](https://travis-ci.org/dyweb/ring)

[![Throughput Graph](https://graphs.waffle.io/dyweb/ring/throughput.svg)](https://waffle.io/dyweb/ring/metrics)

Image & File upload component

![ring-logo](ring.png)

## Features

- handle image & file upload validation
- support different backend, local filesystem, cloud service provider (ie: qiniu, aliyun)

## Usage

see [example/upload](example/upload.php) for how to use 

- add `dyweb/ring` to your `composer.json`

## Development

TODO

## Roadmap

- [x] file upload
- [ ] image upload
- [ ] image upload with thumbnail (thumbnail is treated as meta and store as base64)
- [ ] store meta
- [ ] list file
- [ ] list file by auth
- [ ] list file with thumbnail 
