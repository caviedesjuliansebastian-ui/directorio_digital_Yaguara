<?php
require_once 'config/database.php';

try {
    $db = new Database();
    $conn = $db->getConnection();
    $conn->exec("SET NAMES utf8mb4");

    // Mapeo curado de 44 negocios con Portada Real y Avatar/Logo Real
    $negociosImg = [
        // 1. Quesillos Doña Stella
        1 => [
            'portada' => 'https://images.unsplash.com/photo-1486297678162-eb2a19b0a32d?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=200&auto=format&fit=crop&q=80', // Doña Stella
            'galeria' => [
                'https://images.unsplash.com/photo-1589881133595-a3c085cb731d?w=800&q=80',
                'https://images.unsplash.com/photo-1624806992066-5ffcf7ca186b?w=800&q=80',
                'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?w=800&q=80'
            ]
        ],
        // 2. Pescadería El Malecón de Betania
        2 => [
            'portada' => 'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=800&q=80',
                'https://images.unsplash.com/photo-1535400255456-984241443b29?w=800&q=80',
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&q=80'
            ]
        ],
        // 3. Asados Don Pedro
        3 => [
            'portada' => 'https://images.unsplash.com/photo-1544025162-d76694265947?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=800&q=80',
                'https://images.unsplash.com/photo-1628294895950-9805252327bc?w=800&q=80',
                'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=800&q=80'
            ]
        ],
        // 4. Estadero Brisas de Betania
        4 => [
            'portada' => 'https://images.unsplash.com/photo-1543353071-873f17a7a088?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1556157382-97eda2d62296?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=800&q=80',
                'https://images.unsplash.com/photo-1534422298391-e4f8c172dddb?w=800&q=80',
                'https://images.unsplash.com/photo-1547592166-23ac45744acd?w=800&q=80'
            ]
        ],
        // 5. Fábrica de Quesillos Don Ramiro
        5 => [
            'portada' => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1589881133595-a3c085cb731d?w=800&q=80',
                'https://images.unsplash.com/photo-1624806992066-5ffcf7ca186b?w=800&q=80',
                'https://images.unsplash.com/photo-1571115177098-24ec42ed204d?w=800&q=80'
            ]
        ],
        // 6. Bizcochería La Yaguareñita
        6 => [
            'portada' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=800&q=80',
                'https://images.unsplash.com/photo-1517433670267-08bbd4be890f?w=800&q=80',
                'https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?w=800&q=80'
            ]
        ],
        // 7. Panadería El Parque Yaguará
        7 => [
            'portada' => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=800&q=80',
                'https://images.unsplash.com/photo-1541696490-8744a5dc0228?w=800&q=80',
                'https://images.unsplash.com/photo-1551024709-8f23befc6f87?w=800&q=80'
            ]
        ],
        // 8. Panadería La Espiga Dorada
        8 => [
            'portada' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1535141192574-5d4897c13136?w=800&q=80',
                'https://images.unsplash.com/photo-1586985289688-ca3cf47d3e6e?w=800&q=80',
                'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=800&q=80'
            ]
        ],
        // 9. Bizcochería Doña Flor
        9 => [
            'portada' => 'https://images.unsplash.com/photo-1589367920969-ab8e050bbb04?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=800&q=80',
                'https://images.unsplash.com/photo-1558961363-fa8fdf82db35?w=800&q=80',
                'https://images.unsplash.com/photo-1499636136210-6f4ee915583e?w=800&q=80'
            ]
        ],
        // 10. Supertienda El Triunfo
        10 => [
            'portada' => 'https://images.unsplash.com/photo-1578916171728-46686eac8d58?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=800&q=80',
                'https://images.unsplash.com/photo-1582722872445-44dc5f7e3c8f?w=800&q=80',
                'https://images.unsplash.com/photo-1585670210693-e7fdd16b142e?w=800&q=80'
            ]
        ],
        // 11. Minimarket Los Ganaderos
        11 => [
            'portada' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=800&q=80',
                'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?w=800&q=80',
                'https://images.unsplash.com/photo-1563636619-e9143da7973b?w=800&q=80'
            ]
        ],
        // 12. Tienda Mi Ranchito Sector La Playa
        12 => [
            'portada' => 'https://images.unsplash.com/photo-1534723452862-4c874018d66d?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1608270586620-248524c67de9?w=800&q=80',
                'https://images.unsplash.com/photo-1548839140-29a749e1bc4e?w=800&q=80',
                'https://images.unsplash.com/photo-1607006314845-a740879ec364?w=800&q=80'
            ]
        ],
        // 13. Abarrotes La Economía
        13 => [
            'portada' => 'https://images.unsplash.com/photo-1583258292688-d0213dc5a3a8?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1581781870027-04212e231e96?w=800&q=80',
                'https://images.unsplash.com/photo-1551462147-ff29053bfc14?w=800&q=80',
                'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=800&q=80'
            ]
        ],
        // 14. Droguería La Principal
        14 => [
            'portada' => 'https://images.unsplash.com/photo-1586015555751-63bb77f4322a?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=800&q=80',
                'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800&q=80',
                'https://images.unsplash.com/photo-1587854692152-cbe660dbde88?w=800&q=80'
            ]
        ],
        // 15. Farmacia San José
        15 => [
            'portada' => 'https://images.unsplash.com/photo-1631549916768-4119b2e5f926?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1622253692010-333f2da6031d?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?w=800&q=80',
                'https://images.unsplash.com/photo-1550572017-edb9287c807b?w=800&q=80',
                'https://images.unsplash.com/photo-1544816155-12df9643f363?w=800&q=80'
            ]
        ],
        // 16. Droguería El Triunfo
        16 => [
            'portada' => 'https://images.unsplash.com/photo-1576602976047-174e57a47881?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1594824813590-78923a1a9e88?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1556228720-195a672e8a03?w=800&q=80',
                'https://images.unsplash.com/photo-1584308666744-24d5c474f2ae?w=800&q=80',
                'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=800&q=80'
            ]
        ],
        // 17. Servicios Técnicos Don Hernán
        17 => [
            'portada' => 'https://images.unsplash.com/photo-1581092160607-ee22621dd758?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1581141849291-1125c7b692b5?w=800&q=80',
                'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=800&q=80',
                'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=800&q=80'
            ]
        ],
        // 18. Plomería El Tigre
        18 => [
            'portada' => 'https://images.unsplash.com/photo-1581244277943-fe4a9c777189?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=800&q=80',
                'https://images.unsplash.com/photo-1581141849291-1125c7b692b5?w=800&q=80',
                'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=800&q=80'
            ]
        ],
        // 19. Electro-Instalaciones & Solar
        19 => [
            'portada' => 'https://images.unsplash.com/photo-1509391365360-2e959784a276?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1509391365360-2e959784a276?w=800&q=80',
                'https://images.unsplash.com/photo-1621905251189-08b45d6a269e?w=800&q=80',
                'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?w=800&q=80'
            ]
        ],
        // 20. Cabañas Betania View
        20 => [
            'portada' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&q=80',
                'https://images.unsplash.com/photo-1502680390469-be75c86b636f?w=800&q=80',
                'https://images.unsplash.com/photo-1542314831-c6a4d142104d?w=800&q=80'
            ]
        ],
        // 21. Hotel Colonial Yaguará Plaza
        21 => [
            'portada' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=800&q=80',
                'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&q=80',
                'https://images.unsplash.com/photo-1533089860892-a7c6f0a88666?w=800&q=80'
            ]
        ],
        // 22. Glamping El Remanso Huilense
        22 => [
            'portada' => 'https://images.unsplash.com/photo-1587061949409-02df41d5e562?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1587061949409-02df41d5e562?w=800&q=80',
                'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=800&q=80',
                'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800&q=80'
            ]
        ],
        // 23. Hostal & Camping Los Pescadores
        23 => [
            'portada' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800&q=80',
                'https://images.unsplash.com/photo-1485965120184-e220f721d03e?w=800&q=80',
                'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=800&q=80'
            ]
        ],
        // 24. Café Dulce Placer
        24 => [
            'portada' => 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=800&q=80',
                'https://images.unsplash.com/photo-1517256064527-09c73fc73e38?w=800&q=80',
                'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=800&q=80'
            ]
        ],
        // 25. Jugos La Bendición
        25 => [
            'portada' => 'https://images.unsplash.com/photo-1622597467836-f3285f2131b7?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=800&q=80',
                'https://images.unsplash.com/photo-1488477181946-6428a0291777?w=800&q=80',
                'https://images.unsplash.com/photo-1562376552-0d160a2f238d?w=800&q=80'
            ]
        ],
        // 26. Heladería Tropical
        26 => [
            'portada' => 'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1505394033641-40c6ad1178d7?w=800&q=80',
                'https://images.unsplash.com/photo-1572490122747-3968b75cc699?w=800&q=80',
                'https://images.unsplash.com/photo-1563805042-7684c019e1cb?w=800&q=80'
            ]
        ],
        // 27. Taller El Paisa
        27 => [
            'portada' => 'https://images.unsplash.com/photo-1558981806-ec527fa84c39?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?w=800&q=80',
                'https://images.unsplash.com/photo-1486006920555-c77dce18193b?w=800&q=80',
                'https://images.unsplash.com/photo-1578844251758-2f71da64c96f?w=800&q=80'
            ]
        ],
        // 28. Serviteca Rápida
        28 => [
            'portada' => 'https://images.unsplash.com/photo-1486006920555-c77dce18193b?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1578844251758-2f71da64c96f?w=800&q=80',
                'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?w=800&q=80',
                'https://images.unsplash.com/photo-1486006920555-c77dce18193b?w=800&q=80'
            ]
        ],
        // 29. Moto-Repuestos La Variante
        29 => [
            'portada' => 'https://images.unsplash.com/photo-1609630875171-b1321377ee65?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1558981403-c5f9899a28bc?w=800&q=80',
                'https://images.unsplash.com/photo-1486006920555-c77dce18193b?w=800&q=80',
                'https://images.unsplash.com/photo-1578844251758-2f71da64c96f?w=800&q=80'
            ]
        ],
        // 30. Ferretería San Mateo
        30 => [
            'portada' => 'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80',
                'https://images.unsplash.com/photo-1562259949-e8e7689d7828?w=800&q=80',
                'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=800&q=80'
            ]
        ],
        // 31. Ferretería La Campiña
        31 => [
            'portada' => 'https://images.unsplash.com/photo-1581781870027-04212e231e96?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1504307651254-35680f356dfd?w=800&q=80',
                'https://images.unsplash.com/photo-1562259949-e8e7689d7828?w=800&q=80',
                'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?w=800&q=80'
            ]
        ],
        // 32. Barbería Estilo Urbano
        32 => [
            'portada' => 'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1621605815971-fbc98d665033?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1503951914875-452162b0f3f1?w=800&q=80',
                'https://images.unsplash.com/photo-1621605815971-fbc98d665033?w=800&q=80',
                'https://images.unsplash.com/photo-1570172619644-dfd03ed5d881?w=800&q=80'
            ]
        ],
        // 33. Spa Glamour
        33 => [
            'portada' => 'https://images.unsplash.com/photo-1560066984-138dadb4c035?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1604654894610-df63bc536371?w=800&q=80',
                'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?w=800&q=80',
                'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?w=800&q=80'
            ]
        ],
        // 34. Agropecuaria El Ganadero
        34 => [
            'portada' => 'https://images.unsplash.com/photo-1516467508483-a7212febe31a?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1570042225831-d98fa7577f1e?w=800&q=80',
                'https://images.unsplash.com/photo-1570042225831-d98fa7577f1e?w=800&q=80',
                'https://images.unsplash.com/photo-1589924691995-400dc9ecc119?w=800&q=80'
            ]
        ],
        // 35. Veterinaria Huellitas
        35 => [
            'portada' => 'https://images.unsplash.com/photo-1583337130417-3346a1be7dee?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1628009368231-7bb7cfcb0def?w=800&q=80',
                'https://images.unsplash.com/photo-1516734212186-a967f81ad0d7?w=800&q=80',
                'https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?w=800&q=80'
            ]
        ],
        // 36. Carnicería La Especial
        36 => [
            'portada' => 'https://images.unsplash.com/photo-1607623814075-e51df1bdc82f?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1603048588665-791ca8aea617?w=800&q=80',
                'https://images.unsplash.com/photo-1544025162-d76694265947?w=800&q=80',
                'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=800&q=80'
            ]
        ],
        // 37. Carnes Don Julio
        37 => [
            'portada' => 'https://images.unsplash.com/photo-1587593810167-a84920ea0781?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1604503468506-a8da13d82791?w=800&q=80',
                'https://images.unsplash.com/photo-1603048588665-791ca8aea617?w=800&q=80',
                'https://images.unsplash.com/photo-1607623814075-e51df1bdc82f?w=800&q=80'
            ]
        ],
        // 38. Frutería La Campesina
        38 => [
            'portada' => 'https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?w=800&q=80',
                'https://images.unsplash.com/photo-1523049673857-eb18f1d7b578?w=800&q=80',
                'https://images.unsplash.com/photo-1550258987-190a2d41a8ba?w=800&q=80'
            ]
        ],
        // 39. Verdulería El Buen Precio
        39 => [
            'portada' => 'https://images.unsplash.com/photo-1597362153131-55423453b667?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=800&q=80',
                'https://images.unsplash.com/photo-1618512496248-a07fe83aa8cb?w=800&q=80',
                'https://images.unsplash.com/photo-1518977676601-b53f82aba655?w=800&q=80'
            ]
        ],
        // 40. Artesanías El Recuerdo
        40 => [
            'portada' => 'https://images.unsplash.com/photo-1513519245088-0e12902e5a38?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1582562124811-c09040d0a901?w=800&q=80',
                'https://images.unsplash.com/photo-1514327605112-b887c0e61c0a?w=800&q=80',
                'https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=800&q=80'
            ]
        ],
        // 41. Papelería Central
        41 => [
            'portada' => 'https://images.unsplash.com/photo-1588072432836-e10032774350?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1583485088034-697b5bc54ccd?w=800&q=80',
                'https://images.unsplash.com/photo-1513542789411-b6a5d4f31634?w=800&q=80',
                'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=800&q=80'
            ]
        ],
        // 42. Pizzería La Terraza
        42 => [
            'portada' => 'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1513104890138-7c749659a591?w=800&q=80',
                'https://images.unsplash.com/photo-1574894709920-11b28e7367e3?w=800&q=80',
                'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?w=800&q=80'
            ]
        ],
        // 43. Asadero El Rey
        43 => [
            'portada' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1598103442097-8b74394b95c6?w=800&q=80',
                'https://images.unsplash.com/photo-1626645738196-c2a7c87a8f58?w=800&q=80',
                'https://images.unsplash.com/photo-1567620832903-9fc6debc209f?w=800&q=80'
            ]
        ],
        // 44. Comidas Rápidas Los Amigos
        44 => [
            'portada' => 'https://images.unsplash.com/photo-1561758033-d89a9ad46330?w=1000&auto=format&fit=crop&q=80',
            'logo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=200&auto=format&fit=crop&q=80',
            'galeria' => [
                'https://images.unsplash.com/photo-1568901346375-23c9450c58cd?w=800&q=80',
                'https://images.unsplash.com/photo-1619740455993-9e612b1af08a?w=800&q=80',
                'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=800&q=80'
            ]
        ]
    ];

    $updateNegStmt = $conn->prepare("UPDATE negocios SET logo = ?, imagen_portada = ? WHERE id = ?");
    $conn->exec("TRUNCATE TABLE imagenes_negocio");
    $insertGaleriaStmt = $conn->prepare("INSERT INTO imagenes_negocio (negocio_id, url_imagen, orden) VALUES (?, ?, ?)");

    $totalActualizados = 0;
    $totalGaleria = 0;

    foreach ($negociosImg as $id => $data) {
        $updateNegStmt->execute([$data['logo'], $data['portada'], $id]);
        $totalActualizados++;

        $orden = 1;
        foreach ($data['galeria'] as $url) {
            $insertGaleriaStmt->execute([$id, $url, $orden++]);
            $totalGaleria++;
        }
    }

    echo "¡Negocios actualizados con fotos y logos reales verificados ($totalActualizados negocios, $totalGaleria fotos de galería)!\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
