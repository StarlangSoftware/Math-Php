Video Lectures
============

[<img src=https://github.com/StarlangSoftware/Math/blob/master/video.jpg width="50%">](https://youtu.be/GhcoaVi0SMs)

For Developers
============
You can also see [Java](https://github.com/starlangsoftware/Math), [Python](https://github.com/starlangsoftware/Math-Py), [Js](https://github.com/starlangsoftware/Math-Js),
[Cython](https://github.com/starlangsoftware/Math-Cy), [Swift](https://github.com/starlangsoftware/Math-Swift), 
[C++](https://github.com/starlangsoftware/Math-CPP), [C](https://github.com/starlangsoftware/Math-C), or [C#](https://github.com/starlangsoftware/Math-CS) repository.

## Requirements

* [Php 8.0 or higher](#php)
* [Git](#git)

### Php 

To check if you have a compatible version of Php installed, use the following command:

    php -V
    
You can find the latest version of Php [here](https://www.php.net/downloads/).

### Git

Install the [latest version of Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git).

## Download Code

In order to work on code, create a fork from GitHub page. 
Use Git for cloning the code to your local or below line for Ubuntu:

	git clone <your-fork-git-link>

A directory called DataStructure will be created. Or you can use below link for exploring the code:

	git clone https://github.com/starlangsoftware/Math-Php.git

## Open project with PhpStorm IDE

Steps for opening the cloned project:

* Start IDE
* Select **File | Open** from main menu
* Choose `Math-Php` file
* Select open as project option
* Couple of seconds, dependencies will be downloaded. 

Detailed Description
============

+ [Vector](#vector)
+ [Matrix](#matrix)
+ [Distribution](#distribution)

## Vector

Bir vektör yaratmak için:

	__construct(mixed $valuesOrSize = null, mixed $initial = null, mixed $index = null)

Vektörler eklemek için

	addVector(Vector $v): void

Çıkarmak için

	subtract(Vector $v): void
	difference(Vector $v): Vector

İç çarpım için

	dotProduct(Vector $v): float
	dotProductWithItself(): float

Bir vektörle cosinüs benzerliğini hesaplamak için

	cosineSimilarity(Vector $v): float

Bir vektörle eleman eleman çarpmak için

	elementProduct(Vector $v): Vector

## Matrix

3'e 4'lük bir matris yaratmak için

	$a = new Matrix(3, 4)

Elemanları rasgele değerler alan bir matris yaratmak için

	__construct(mixed $row, mixed $col = null, mixed $minValue = null, mixed $maxValue = null)

Örneğin, 

	$a = new Matrix(3, 4, 1, 5)
 
3'e 4'lük elemanları 1 ve 5 arasında değerler alan bir matris yaratır.

Matrisin i. satır, j. sütun elemanını getirmek için 

	getValue(int $rowNo, int $colNo): float

Örneğin,

	$a->getValue(3, 4)

3. satır, 4. sütundaki değeri getirir.

Matrisin i. satır, j. sütunundaki elemanı değiştirmek için

	setValue(int $rowNo, int $colNo, float $value): void

Örneğin,

	$a->setValue(3, 4, 5)

3. satır, 4.sütundaki elemanın değerini 5 yapar.

Matrisleri toplamak için

	add(Matrix|int $m, Vector $v = null): void

Çıkarmak için 

	subtract(Matrix $m): void

Çarpmak için 

	multiply(Matrix $m): Matrix

Elaman eleman matrisleri çarpmak için

	elementProduct(Matrix|Vector $m): Matrix

Matrisin transpozunu almak için

	transpose(): Matrix

Matrisin simetrik olup olmadığı belirlemek için

	isSymmetric(): bool

Determinantını almak için

	determinant(): float

Tersini almak için

	inverse(): void

Matrisin eigenvektör ve eigendeğerlerini bulmak için

	characteristics(): array

Bu metodla bulunan eigenvektörler eigendeğerlerine göre büyükten küçüğe doğru 
sıralı olarak döndürülür.

## Distribution

Verilen bir değerin normal dağılımdaki olasılığını döndürmek için

	zNormal(float $z): float

Verilen bir olasılığın normal dağılımdaki değerini döndürmek için

	zInverse(float $p): float

Verilen bir değerin chi kare dağılımdaki olasılığını döndürmek için

	chiSquare(float $x, int $freedom): float

Verilen bir olasılığın chi kare dağılımdaki değerini döndürmek için

	chiSquareInverse(float $p, int $freedom): float

Verilen bir değerin F dağılımdaki olasılığını döndürmek için

	fDistribution(float $F, int $freedom1, int $freedom2): float

Verilen bir olasılığın F dağılımdaki değerini döndürmek için

	fDistributionInverse(float $p, int $freedom1, int $freedom2): float

Verilen bir değerin t dağılımdaki olasılığını döndürmek için

	tDistribution(float $T, int $freedom): float

Verilen bir olasılığın t dağılımdaki değerini döndürmek için

	tDistributionInverse(float $p, int $freedom): float
