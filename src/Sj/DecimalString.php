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
class Sj_DecimalString
{
    /**
     * @var string
     */
    private $value;

    /**
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value = (string)$value;
    }

    /**
     * @return integer
     */
    public function getScale()
    {
        $hit = strrpos($this->value, '.');
        if ($hit === false) {
            return 0;
        } else {
            return strlen($this->value) - $hit - 1;
        }
    }

    /**
     * @throws InvalidArgumentException
     * @param $value
     */
    public static function assertNumerical($value)
    {
        if (!is_numeric($value)) {
            throw new InvalidArgumentException('string is not numerical.');
        }
    }
}
