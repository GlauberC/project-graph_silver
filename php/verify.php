<?php
require_once ("input.php");
echo "
            <div id='verify_list'>
              <nav>
                <a class='btn btn-default' data-toggle='modal' href='#property-modal' onClick='addPropClick()'>Add Property</a>
                <button class='btn btn-default pull-right'>Verify All</button>
                <button class='btn btn-default pull-right disabled'>Stop</button>
              </nav>
              <div class='table'>
                <table class='table-verify table'>
                  <thead>
                    <th>Status</th>
                    <th>Time</th>
                    <th>Property &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th>Verify</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </thead>
                  <tbody class='verify-list'>
                  </tbody>
                </table>
              </div>

            </div>


            <section id='property-modal' class='container-property container modal fade' role='dialog'>
              <div class='modal-content'>
                <div class='modal-header'>
                  <h4 class='modal-title'>
                    <b>Add/Edit Property</b>
                  </h4>
                </div>

                <div class='modal-body'>
                  <h3>Property Type</h3>
                  <div class='radio'>
                    <label>
                      <input id='equivalence' class='radioProp' type='radio' name='property-type' value='0' onClick='propEquivalence()'>Equivalence/Preorder Checking
                    </label>
                  </div>

                  <div class='radio'>
                    <label>
                      <input id='model' class='radioProp' type='radio' name='property-type' value='1' onClick='propModel()'>Model Checking
                    </label>
                  </div>

                </div>



                <div id='propEqui' class='prop-option'>
                  <div class='selected-equivalence row'>
                    <div>
                      <div class = 'left-process col-lg-6'>
                        <label for='left'>Left process</label><br/>
                        <select id = 'leftp' class = 'btn btn-default bissim-process1'>";
                          foreach ($select as $process_label) {
                            $process_label = str_replace('\'', '', $process_label);
                            echo "<option>$process_label</option>";
                          }
                        echo "</select>
                      </div>

                      <div class = 'right-process col-lg-6'>
                        <label for='right'>Right process</label><br/>
                        <select id = 'rightp' class = 'btn btn-default bissim-process2'>";
                            foreach ($select as $process_label) {
                                $process_label = str_replace('\'', '', $process_label);
                                echo "<option>$process_label</option>";
                            }
                            echo "</select>
                       </div>

                       <div class='prop form-group col-lg-8'>
                            <label for='property-id'>Property ID:</label>
                            <input type='text' class='form-control property-id'>
                     </div>
                  </div>
                </div>
              </div>


              <div id='propMod' class='prop-option' style='display: none;'>
                <div class='selected-model row'>
                  <div>
                    <div class = 'left-model-process col-lg-3'>
                        <label for='left'>Left process</label><br/>
                        <select id = 'leftp' class = 'btn btn-default model-process-select model-process'>";
                            foreach ($select as $process_label) {
                                $process_label = str_replace('\'', '', $process_label);
                                echo "<option>$process_label</option>";
                            }
                        echo "</select>
                     </div>

                     <div class = 'left-model-process col-lg-1'>
                         <h3 class='equal-definition'>=</h3>
                     </div>

                     <div class = 'right-process col-lg-8'>
                        <label for='property-id'>Formula</label>
                        <input type='text' class='form-control formula-id'>
                     </div>

                   </div>

                </div>

              </div>


              <div class='modal-footer'>
                    <button type='button' class='btn-prop btn btn-default' data-dismiss='modal'>Cancel</button>
                    <button type='button' class='btn-prop btn-prop-save btn btn-primary' onclick='savebtn()' data-dismiss='modal'>Save</button>
              </div>

            </section>";
            echo "<div class = 'test'>Test</div> "; //deletar after test Model check
?>
