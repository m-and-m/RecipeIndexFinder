Recipe Index Finder
=================
**Table Schema**  
RECIPE
```
recipeid INT NOT NULL
name VARCHAR(50) NOT NULL
resource VARCHAR(50)
resourcelink VARCHAR(200)
PRIMARY KEY(recipeid)
```
TAG
```
tagid VARCHAR(10) NOT NULL
name VARCHAR(30)
PRIMARY KEY(tagid)
```

RECIPETAG
```
recipeid INT NOT NULL
tagid VARCHAR(10) NOT NULL
```

CONTENTS
```
recipeid INT NOT NULL,
ingredients TEXT,
instructions TEXT,
PRIMARY KEY(recipeid)
```