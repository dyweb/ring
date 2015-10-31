# Ring

[![Build Status](https://travis-ci.org/dyweb/ring.svg?branch=master)](https://travis-ci.org/dyweb/ring)

[![Throughput Graph](https://graphs.waffle.io/dyweb/ring/throughput.svg)](https://waffle.io/dyweb/ring/metrics)

An php file upload solution for lazy web developers

![ring-logo](ring.png)

## Why Ring?

Because file & image upload is common problem for php developers, especially when they want to build a website
with rich text editing feature. It's a pain to write the same logic again and again. As for front end, it's even
worse, for the editors that support image/file upload, some got a single php file for handle image upload, some got
a charged file manager, and most of these code are just too old to fix/add features like access control. 

As for the name, it's the nick name of a guy from our design team at [dyweb](https://github.com/dyweb)

## Features

- handle image & file upload validation
- support different backend, local filesystem, cloud service provider (ie: qiniu, aliyun)
- store data and meta separately
- generate json directly from meta class (using JsonSerialize)
- acl for file
- file manager, see [MissAtomicBomb](https://github.com/at15/MissAtomicBomb)

see [doc](doc) for more information

## Usage

see [example/upload](example/upload.php) for how to use 

- add `dyweb/ring` to your `composer.json`

## Development

TODO

## Roadmap

- [x] file upload
- [ ] image upload
- [ ] image upload with thumbnail (thumbnail is treated as meta and store as base64)
- [ ] a tree structure to simulate folder structure OR use flysystem
- [ ] store meta, include image thumbnail
- [ ] list file
- [ ] list file by auth
- [ ] list file with thumbnail 
