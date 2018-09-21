<?php

use function Eloquent\Phony\Kahlan\stub;

use Quanta\Undefined;
use Quanta\BoundCallable;

describe('BoundCallable', function () {

    beforeEach(function () {

        $this->callable = stub();

        $this->partial = new BoundCallable($this->callable, 'v3', 2);

    });

    describe('->__invoke()', function () {

        context('when enough arguments are given', function () {

            it('should call the callable once', function () {

                ($this->partial)('v1', 'v2');

                $this->callable->once()->called();

            });

            it('should call the callable with the bound argument completed with the given arguments', function () {

                ($this->partial)('v1', 'v2', 'v4');

                $this->callable->calledWith('v1', 'v2', 'v3', 'v4');

            });

            it('should return the value produced by the callable', function () {

                $this->callable->returns('value');

                $test = ($this->partial)('v1', 'v2');

                expect($test)->toEqual('value');

            });

        });

        context('when not enough arguments are given', function () {

            it('should replace the missing arguments with Quanta\Undefined::class', function () {

                ($this->partial)('v1');

                $this->callable->calledWith('v1', Undefined::class, 'v3');

            });

        });

    });

});
