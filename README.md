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

	Vector(valuesOrSize: any = undefined, initial: any = undefined, index: any = undefined)

Vektörler eklemek için

	addVector(v: Vector)

Çıkarmak için

	subtract(v: Vector)
	difference(v: Vector): Vector

İç çarpım için

	dotProduct(v: Vector): number
	dotProductWithSelf(): number

Bir vektörle cosinüs benzerliğini hesaplamak için

	cosineSimilarity(Vector v): number

Bir vektörle eleman eleman çarpmak için

	elementProduct(v: Vector): Vector

## Matrix

3'e 4'lük bir matris yaratmak için

	a = Matrix(3, 4)

Elemanları rasgele değerler alan bir matris yaratmak için

	Matrix(row: any, col: any = undefined, minValue: any = undefined, maxValue: any = undefined)

Örneğin, 

	a = Matrix(3, 4, 1, 5)
 
3'e 4'lük elemanları 1 ve 5 arasında değerler alan bir matris yaratır.

Matrisin i. satır, j. sütun elemanını getirmek için 

	getValue(rowNo: number, colNo: number): number

Örneğin,

	a.getValue(3, 4)

3. satır, 4. sütundaki değeri getirir.

Matrisin i. satır, j. sütunundaki elemanı değiştirmek için

	setValue(rowNo: number, colNo: number, value: number)

Örneğin,

	a.setValue(3, 4, 5)

3. satır, 4.sütundaki elemanın değerini 5 yapar.

Matrisleri toplamak için

	add(m: Matrix | number, v: any = undefined)

Çıkarmak için 

	subtract(m: Matrix)

Çarpmak için 

	multiply(m: Matrix): Matrix

Elaman eleman matrisleri çarpmak için

	elementProduct(m: Matrix | Vector): Matrix

Matrisin transpozunu almak için

	transpose(): Matrix

Matrisin simetrik olup olmadığı belirlemek için

	isSymmetric(): boolean

Determinantını almak için

	determinant(): number

Tersini almak için

	inverse()

Matrisin eigenvektör ve eigendeğerlerini bulmak için

	characteristics(): Array<Eigenvector>

Bu metodla bulunan eigenvektörler eigendeğerlerine göre büyükten küçüğe doğru 
sıralı olarak döndürülür.

## Distribution

Verilen bir değerin normal dağılımdaki olasılığını döndürmek için

	zNormal(z: number): number

Verilen bir olasılığın normal dağılımdaki değerini döndürmek için

	zInverse(p: number): number

Verilen bir değerin chi kare dağılımdaki olasılığını döndürmek için

	chiSquare(x: number, freedom: number): number

Verilen bir olasılığın chi kare dağılımdaki değerini döndürmek için

	chiSquareInverse(p: number, freedom: number)

Verilen bir değerin F dağılımdaki olasılığını döndürmek için

	fDistribution(F: number, freedom1: number, freedom2: number): number

Verilen bir olasılığın F dağılımdaki değerini döndürmek için

	fDistributionInverse(p: number, freedom1: number, freedom2: number): number

Verilen bir değerin t dağılımdaki olasılığını döndürmek için

	tDistribution(T: number, freedom: number): number

Verilen bir olasılığın t dağılımdaki değerini döndürmek için

	tDistributionInverse(p: number, freedom: num
