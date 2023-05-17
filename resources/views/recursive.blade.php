
<?php
traverseArray($projectTree, $project_id);

function traverseArray($DataArray, $project_id){
    //setup
    $numberOfArrays= 0;

    foreach ($DataArray as $value){
        if (is_array($value)) $numberOfArrays++;
    }


    //action
    echo '<ul class="list-group">';
    echo '<li class="list-group-item">';
        echo '<a>'.$DataArray['name'].' - '.$DataArray['description'].'</a>';
        echo '
            <div class="btn-group dropend">
                <button type="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-three-dots"></i>
                </button>
                <ul class="dropdown-menu">
                <li><a class="dropdown-item">';
                    switch($DataArray['type']){ 
                        case 10: //////////////////////////////////////ATTRIBUTE
                        if($numberOfArrays == 0){
                            echo '<form method="post" action='.route('value.new', ['item_id'=>$DataArray['id'], 'project_id'=>$project_id]).'>
                            <input type="hidden" name="_token" value="'.csrf_token().'" />       
                            <div class="row">
                                <div class="col">
                                    <div class="col">
                                        <label for="name1" class="form-label">'.__('messages.createValueLabel').'</label>
                                    </div>
                                    <input type="text" placeholder="'.__('messages.itemNamePlaceholder').'" name="name">
                                </div>
                                <div class="col">
                                    <input type="text" placeholder="'.__('messages.itemDescriptionPlaceholder').'" name="description">
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-outline-success form-control">'.__('messages.createButtonLabel').'</button>
                                </div>
                            </div>    
                            </form>
                        </a></li>
                        <li>
                            <form method="post" action="'.route('attribute.delete', ['item_id'=>$DataArray['id'], 'project_id'=>$project_id]).'">
                            <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <a class="dropdown-item"><button type="submit"><i class="bi bi-trash"></i></button></a>
                            </form>
                        </li>
                        </ul>
                        </div>';
                        } else{
                            echo '<form method="post" action='.route('attribute.update', ['item_id'=>$DataArray['id'], 'project_id'=>$project_id]).'>
                            <input type="hidden" name="_token" value="'.csrf_token().'" />       
                            <div class="row">
                                <div class="col">
                                    <div class="col">
                                        <label for="name1" class="form-label">'.__('messages.editAttributeLabel').'</label>
                                    </div>
                                    <input type="text" value="'.$DataArray['name'].'" name="name">
                                </div>
                                <div class="col">
                                    <input type="text" value="'.$DataArray['description'].'" name="description">
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-outline-success form-control">'.__('messages.saveButtonLabel').'</button>
                                </div>
                            </div>
                            </form>
                            <form method="post" action='.route('value.new', ['item_id'=>$DataArray['id'], 'project_id'=>$project_id]).'>
                            <input type="hidden" name="_token" value="'.csrf_token().'" />       
                            <div class="row">
                                <div class="col">
                                    <div class="col">
                                        <label for="name1" class="form-label">'.__('messages.createValueLabel').'</label>
                                    </div>
                                    <input type="text" placeholder="'.__('messages.itemNamePlaceholder').'" name="name">
                                </div>
                                <div class="col">
                                    <input type="text" placeholder="'.__('messages.itemDescriptionPlaceholder').'" name="description">
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-outline-success form-control">'.__('messages.createButtonLabel').'</button>
                                </div>
                            </div>    
                            </form>
                        </a></li>
                        <li>
                            <form method="post" action="'.route('attribute.delete', ['item_id'=>$DataArray['id'], 'project_id'=>$project_id]).'">
                            <input type="hidden" name="_token" value="'.csrf_token().'" />
                                <a class="dropdown-item"><button type="submit"><i class="bi bi-trash"></i></button></a>
                            </form>
                        </li>
                        </ul>
                        </div>';
                        }
                        break;
                        case 20: ///////////////////////////VALUE
                        if($numberOfArrays == 0){
                            echo '<form method="post" action="'.route('conclusion.new', ['item_id'=>$DataArray['id'], 'project_id'=>$project_id]).'">
                            <input type="hidden" name="_token" value="'.csrf_token().'" /> 
                            <div class="row">
                                <div class="col">
                                    <div class="col">
                                        <label for="name1" class="form-label">'.__('messages.createConclusionLabel').'</label>
                                    </div>
                                        <input type="text" placeholder="'.__('messages.itemNamePlaceholder').'" name="name">
                                    </div>
                                <div class="col">
                                    <input type="text" placeholder="'.__('messages.itemDescriptionPlaceholder').'" name="description">
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-outline-success form-control">'.__('messages.createButtonLabel').'</button>
                                </div>
                            </div>    
                            </form>
                            </a></li>
                            <li>
                            <div class="dropdown-item">
                                <form method="post" action="'.route('attribute.new', ['item_id'=>$DataArray['id'], 'project_id'=>$project_id, 'createForProject'=>false]).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                    <div class="row">
                                        <div class="col">
                                            <div class="col">
                                                <label for="name1" class="form-label">'.__('messages.createAttributeLabel').'</label>
                                            </div>
                                            <div class="col">
                                            <input type="text" placeholder="'.__('messages.itemNamePlaceholder').'" name="name">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <input type="text" placeholder="'.__('messages.itemDescriptionPlaceholder').'" name="description">
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-outline-success form-control">'.__('messages.createButtonLabel').'</button>    
                                        </div>
                                    </div>    
                                </form>
                            </div>    
                            </li>
                            <li>
                                <form method="post" action="'.route('value.delete', ['item_id'=>$DataArray['id'], 'project_id'=>$project_id]).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                    <a class="dropdown-item"><button type="submit"><i class="bi bi-trash"></i></button></a>
                                </form>
                            </li>
                        </ul>
                        </div>
                        ';
                        } else {
                            echo '<form method="post" action="'.route('value.update', ['item_id'=>$DataArray['id'], 'project_id'=>$project_id]).'">
                            <input type="hidden" name="_token" value="'.csrf_token().'" /> 
                            <div class="row">
                                <div class="col">
                                    <div class="col">
                                        <label for="name1" class="form-label">'.__('messages.editValueLabel').'</label>
                                    </div>
                                        <input type="text" value="'.$DataArray['name'].'" name="name">
                                    </div>
                                <div class="col">
                                    <input type="text" value="'.$DataArray['description'].'" name="description">
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-outline-success form-control">'.__('messages.saveButtonLabel').'</button>
                                </div>
                            </div>    
                            </form>
                            </a></li>
                            <li>
                                <form method="post" action="'.route('value.delete', ['item_id'=>$DataArray['id'], 'project_id'=>$project_id]).'">
                                <input type="hidden" name="_token" value="'.csrf_token().'" />
                                    <a class="dropdown-item"><button type="submit"><i class="bi bi-trash"></i></button></a>
                                </form>
                            </li>
                        </ul>
                        </div>';
                        }
                        break;
                        case 30: /////////////////////////////CONCLUSION   
                        echo   '<form method="post" action="'.route('conclusion.update', ['item_id'=>$DataArray['id'], 'project_id'=>$project_id]).'">
                        <input type="hidden" name="_token" value="'.csrf_token().'" /> 
                        <div class="row">
                            <div class="col">
                                <div class="col">
                            <label for="name1" class="form-label">'.__('messages.editConclusionLabel').'</label>
                        </div>
                        <input type="text" value="'.$DataArray['name'].'" name="name">
                        </div>
                            <div class="col">
                            <input type="text" value="'.$DataArray['description'].'" name="description">
                        </div>
                            <div class="col">
                                <button type="submit" class="btn btn-outline-success form-control">'.__('messages.saveButtonLabel').'</button>    
                            </div>
                        </div>    
                        </form>
                        </a></li>
                        <li>
                        <form method="post" action="'.route('conclusion.delete', ['item_id'=>$DataArray['id'], 'project_id'=>$project_id]).'">
                        <input type="hidden" name="_token" value="'.csrf_token().'" />
                            <a class="dropdown-item"><button type="submit"><i class="bi bi-trash"></i></button></a>
                        </form>
                        </li>
                        </ul>
                        </div>
                        ';
                        break;    
                    }
            
    foreach ($DataArray as $arrayValue){
        if (is_array($arrayValue))
        {
            traverseArray($arrayValue, $project_id);
        }
    }
        echo '</li>';
    echo '</ul>';
}
?>
