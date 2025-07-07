                        <div class="card border-0 rounded-4 shadow-sm mb-4" style="background:#f8fbff;">
                            <div class="card-header bg-white border-0 rounded-top-4" style="border-bottom:1px solid #e0e7ef; background:#e0f2fe;">
                                <h4 class="card-title fw-bold mb-0" style="color:#0369a1;letter-spacing:0.5px;">Hasil Nilai Preferensi (P)</h4>
                            </div>
                            <div class="card-body table-responsive rounded-4 overflow-hidden">
                                <?php
                                // --- Perhitungan SAW (normalisasi) ---
                                // Ambil bobot
                                $W = array();
                                $wq = $db->query('SELECT weight FROM saw_criterias ORDER BY id_criteria');
                                while ($w = $wq->fetch_object()) $W[] = $w->weight;
                                // Ambil supplier dan kriteria
                                $supplier = [];
                                $sql = 'SELECT id_supplier, name FROM supplier ORDER BY id_supplier';
                                $result = $db->query($sql);
                                while ($row = $result->fetch_object()) {
                                    $supplier[$row->id_supplier] = $row->name;
                                }
                                $result->free();
                                $kriteria = [];
                                $sql = 'SELECT id_criteria, attribute FROM saw_criterias ORDER BY id_criteria';
                                $result = $db->query($sql);
                                while ($row = $result->fetch_object()) {
                                    $kriteria[$row->id_criteria] = $row->attribute;
                                }
                                $result->free();
                                // Ambil semua nilai asli untuk normalisasi
                                $X = array();
                                $sql = "SELECT id_supplier, id_criteria, value FROM saw_evaluations ORDER BY id_criteria, id_supplier";
                                $result = $db->query($sql);
                                while ($row = $result->fetch_object()) {
                                    $X[$row->id_criteria][$row->id_supplier] = $row->value;
                                }
                                // Normalisasi sesuai metode SAW
                                $R = array();
                                $supplier_ids = array_keys($supplier);
                                $kriteria_ids = array_keys($kriteria);
                                foreach ($supplier_ids as $id_supplier) {
                                    $R[$id_supplier] = array();
                                    foreach ($kriteria_ids as $idx => $id_criteria) {
                                        $values = isset($X[$id_criteria]) ? $X[$id_criteria] : array();
                                        $v = isset($X[$id_criteria][$id_supplier]) ? $X[$id_criteria][$id_supplier] : 0;
                                        $attr = $kriteria[$id_criteria];
                                        if ($attr == 'benefit') {
                                            $max = !empty($values) ? max($values) : 1;
                                            $norm = $max ? $v / $max : 0;
                                        } else {
                                            $min = !empty($values) ? min($values) : 1;
                                            $norm = $v ? $min / $v : 0;
                                        }
                                        $R[$id_supplier][$idx] = $norm;
                                    }
                                }
                                // Hitung preferensi
                                $P = array();
                                $m = count($W);
                                foreach ($R as $i => $r) {
                                    $P[$i] = 0;
                                    for ($j = 0; $j < $m; $j++) {
                                        $P[$i] += $r[$j] * $W[$j];
                                    }
                                    $P[$i . '_name'] = $supplier[$i];
                                }
                                // Urutkan dari yang tertinggi
                                $sorted = array();
                                foreach ($P as $k => $v) {
                                    if (strpos($k, '_name') === false) $sorted[$k] = $v;
                                }
                                arsort($sorted);
                                ?>
                                <table class="table table-hover align-middle mb-0" style="background:#fff;">
                                    <thead style="background:#e0f2fe;">
                                        <tr style="font-size:1.05rem; color:#0369a1;">
                                            <th>Supplier</th>
                                            <th>Nilai Preferensi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($sorted as $id => $nilai) {
                                            $name = isset($P[$id . '_name']) ? $P[$id . '_name'] : '';
                                            echo "<tr><td class='fw-semibold text-dark'>".htmlspecialchars($name)."</td><td class='fw-semibold text-dark'>".round($nilai,4)."</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>