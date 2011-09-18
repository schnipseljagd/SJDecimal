<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information, see
 * <https://github.com/schnipseljagd/SJDecimal>.
 */

/**
 * @license http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @link    https://github.com/schnipseljagd/SJDecimal
 * @author  Hinrich Sager
 * @author  Joscha Meyer
 */
abstract class Sj_Rounder_AbstractRounder
{
    /**
     * @param string $val
     * @param int $steps
     * @param int $scale
     *
     * @return string
     */
    public function shiftPointRight($val, $steps, $scale)
    {
        return bcmul($val, bcpow('10', $steps), $scale);
    }

    /**
     * @param string $val
     * @param int $steps
     * @param int $scale
     *
     * @return string
     */
    public function shiftPointLeft($val, $steps, $scale)
    {
        return bcdiv($val, bcpow('10', $steps), $scale);
    }

    /**
     * @param string $val
     * @param int $scale
     *
     * @return string
     */
    public function extractDecimalPart($val, $scale)
    {
        return bcsub($val, $this->extractIntegerPart($val), $scale + 1);
    }

    /**
     * @param string $v
     *
     * @return string
     */
    public function extractIntegerPart($v)
    {
        $parts = explode('.', $v);
        return $parts[0];
    }

    /**
     * @param $val
     * @return integer
     */
    protected function extractScaleFromString($val)
    {
        $valOperator = new Sj_DecimalString($val);
        return $valOperator->getScale();
    }
}