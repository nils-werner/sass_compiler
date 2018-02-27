# JIT SASS Compiler #

"Just in time" SASS compiler for Symphony CMS.

- Version: 1.1.1
- Date: 27th February 2018
- Requirements: Symphony 2.6 or later
- Author: Nils Werner, nils.werner@gmail.com
- GitHub Repository: <http://github.com/nils-werner/sass_compiler>

## Synopsis

A simple way to compile SASS and SCSS files on the fly via the URL.

## Installation

This extension maks use of the [Sass Parser](https://github.com/richthegeek/phpsass/) as a submodule

If downloading through Git use the command: git clone --recursive https://github.com/nils-werner/sass_compiler.git
Information about Git [submodules](https://www.getsymphony.com/learn/articles/view/on-git-submodules/) can be found in the Symphony documentation at <https://www.getsymphony.com/learn>.


## Usage

### Basics

Similar to JIT Image Manipulation: Just include your SCSS stylesheet, say `workspace/assets/style.scss` using

	<link rel="stylesheet" href="/scss/assets/style.scss" />

Alternatively, you can use the older, less CSS-like dialect of SASS:

	<link rel="stylesheet" href="/sass/assets/style.sass" />
