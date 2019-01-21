# refmanager
A more usable alternative to EndNote, made for AgriCoat Ltd as FOSS, to organise a scientific paper library

## Work in Progress...

### So far we have:
* minimum viable product (search, add, edit, pdf handling)

### Next targets are:
* Add bootstrap CSS to the 'static' directory
* Add the 'errors' page
    * check for duplicate numbers
    * check for missing numbers
    * check for typos
* Centralise all to a config file.

### Todos:
- [x] "Add Record" page (suggest successor of max of keys)
  - [x] "Add PDF" page
- [x] "Edit Record" page (remove record)
- [x] "Search"
  - [x] Sort by record number, date (sort by author?)
  - [x] Search by keyword, abstracts, titles, record number and/or author
- [ ] 'errors' page
  - [ ] highlight missing PDFs
  - [ ] highlight spelling errors?
  - [ ] highlight missing record numbersi

### Prerequisites:
A MySQL server has to be set up with the following fields:
- id (INT(11), AUTO INCREMENT, UNIQUE)
- key (INT(10))
- haspdf (TINYINT(4))
- pdf (LONGBLOB)
And the following TEXT fields:
- title 
- abstract
- author
- comments
- keywords
- pages
- number
- url
- volume
- year




