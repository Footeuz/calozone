<?php
$solution = "
OCCASIONNELLEMENT#CP
PRENANT#UNI#NENUPHAR
PANES#EVITANT#IDEALE
ONT##F#IRONIE#GI#LOF
RER#BISEAUTE#OMS#AGE
TREMOLOS#REZ#DETALER
U#SENTI#####LYSES#RE
NI#DIRE#####OS#SELON
INTIMES#####USA#PI#C
TOISEE######AERAS#SE
ECRAN#E#####NEGLIGE#
#U#NTSC#####E#OIE#NT
PLATEAU######OTE#ISR
REVEUR#GIOACCHINO#IO
ARA#S#TUTRICE#Q#IMBU
LANCERAIENT#POU#SAIS
I#CASENT#I#W#DEREELS
NOEL#N#AMENAGE#ALLIE
ENROLE#RARETE#SVELTE
SUA#USEE#EST#NUITEES
";

if ($_GET["check"] == 1) {
    $schema = trim($_GET["schema"]);
}
?>

<div>
<textarea id="create_crossword" name="create_crossword" rows="10" cols="50">
<?php echo $solution; ?>
</textarea>

<textarea id="create_hor" name="create_hor" rows="10" cols="50">
1 Parfois
16 Post maternelle
18 Absorbant
19 Monochrome
20 Plante aquatique
22 Enduits de chapelure
23 Parant
26 Parfaite
27 Possèdent
29 Cynisme
30 Soldat
31 Registre canin
32 Transilien
33 Taillé en pointe
35 Institution médicale mondiale
36 Vieux
37 Vibratos
39 Bas étage
40 Décamper
42 Eprouvé
43 Agonies cellulaires
44 Note
45 Conjonction
47 Un succès de Calo
48 Pépin
49 Conformément à
51 Personnels
53 Elima
55 Nombre
56 Méprisée
57 Ventilas
59 Réfléchi
60 Grand au cinéma
62 Oublie
63 Standard vidéo
65 Palmipède
66 Ancien Windows
68 Scène de télé
70 Enlève
71 Placement durable
72 Absent
73 Frère
80 Vache
81 Oiseau
82 Responsable
83 Prétentieux
85 Jetteraient
88 Parasite
90 Connais
91 Logent
93 Autistiques
95 Fête
97 Organise
101 Associé
102 Engage
104 Trésor de collectionneur
105 Elancé
106 Transpira
107 Fatiguée
108 Existe
109 Durées hôtelières
</textarea>

<textarea id="create_ver" name="create_ver" rows="10" cols="50">
1 Occasion
68 Bouchées gourmandes
2 Parader
46 Transmettra
96 Institution mondiale
3 Milieux
52 Jet
69 Progressera
4 Baudet
38 Fielleuse
86 On l'adore ici
5 Chambre
33 Baratineuse
103 Parcouru
6 Pas out
28 Tamisée
64 Poisson
87 Brides
7 Enlève
34 Pelage d'insecte
61 Pièce d'or
82 Tangente
24 Existences
73 Basse pour Calo
8 Lèsera
74 Fin de messe
98 Possessif
9 Voisinnage
75 Sillon
10 Amicale
76 Subjonctif
99 Eclos
25 Réfutez
77 Centimètre cube
92 Unité de puissance
11 Greffe
43 Duettiste sur Mistral gagnant
78 Pied de vigne
100 Géant américain
12 Réfléchi
35 Aventure
70 Interjection
89 Poème
13 Mystères
54 Familier
105 Connu
14 Naturistes
58 Extra terrestre
94 Volé
15 Mini société
41 Désinfection
79 Jeune volatile
21 Autorisé par le Coran
50 51
84 Protégée de Calo
16 Notre lien
59 Délicatesse
17 Chantée en duo
67 Assemblées

</textarea>
</div>