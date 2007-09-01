<?php
/*
 * $Id: Xml.php 1838 2007-06-26 00:58:21Z nicobn $
 *
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
 * <http://www.phpdoctrine.com>.
 */

/**
 * class Doctrine_Export_Schema_Xml
 *
 * @package     Doctrine
 * @category    Object Relational Mapping
 * @link        www.phpdoctrine.com
 * @license     http://www.opensource.org/licenses/lgpl-license.php LGPL
 * @version     $Revision: 1838 $
 * @author      Nicolas Bérard-Nault <nicobn@gmail.com>
 */
class Doctrine_Export_Schema_Xml extends Doctrine_Export_Schema
{
    /**
     * build
     * 
     * Build the schema xml string to be dumped to file
     *
     * @param string $array 
     * @return void
     */
    public function build($array)
    {
        $xml = new SimpleXMLElement();
        
        foreach ($array as $tableName => $fields) {
            $table = $xml->addChild('table');
            $name = $table->addChild('name', $tableName);
            $declaration = $table->addChild('declaration');
            
            foreach ($fields as $fieldName => $properties) {
                $field = $declaration->addChild('field');
                $field->addChild('name', $fieldName);
                
                foreach ($properties as $key => $value) {
                    $field->addChild($key, $value);
                }
            }
        }
        
        return $xml->asXml();
    }
    
    /**
     * dump
     * 
     * Dump the array to the schema file
     *
     * @param string $array
     * @param string $schema
     * @return void
     */
    public function dump($array, $schema)
    {
        $xml = $this->build($array);
        
        file_put_contents($schema, $xml);
    }
}