# Code Citations

## License: unknown
https://github.com/rickyginting/spksaw/tree/4852623e2793393f8d33f5e9026e6628fa0d01de/matrik.php

```sql
-- Normalisasi nilai matriks untuk kriteria bertipe 'benefit' dan 'cost'
IF(
  a.id_criteria = 1,
  IF(
    b.attribute = 'benefit',
    a.value / MAX($X[1]),         -- Untuk benefit: nilai dibagi nilai maksimum
    MIN($X[1]) / a.value          -- Untuk cost: nilai minimum dibagi nilai
  ),
  0
)
```

## License: unknown
https://github.com/fdll14/SPK-Kelompok/tree/53267144207e1f7cf8e5055944cfd14b756af3e8/matrik.php

```sql
IF(
  a.id_criteria = 3,
  IF(
    b.attribute = 'benefit',
    a.value / MAX($X[3]),
    MIN($X[3]) / a.value
  ),
  0
) AS C3,
SUM(
  IF(
    a.id_criteria = 4,
    IF(
      b.attribute = 'benefit',
      a.value
      -- ...lanjutan kode...
    )
  )
)
```

## License: unknown
https://github.com/diegoray/spk-saw/tree/b81cb8635b57e8930fa9d9f67ddea6bfc69ad490/R.php

```sql
IF(
  a.id_criteria = 1,
  IF(
    b.attribute = 'benefit',
    a.value / MAX($X[1]),
    MIN($X[1]) / a.value
  ),
  0
) AS C1,
SUM(...)
```

