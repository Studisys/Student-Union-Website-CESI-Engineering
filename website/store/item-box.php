

            <div class="contenu10">

                <div class="contenu100">
                    <p><?php echo($datasItemStore["Titre"]);?></p>
                    </br>
                </div>

                <div class="contenu101">
                <img
                    src="<?php echo($datasItemStore["Image"]);?>"
                    alt="<?php echo($datasItemStore["Description"]);?>"
                    height="100%" 
                    width="100%" 
                />
                     </br>
                </div>

                <div class="contenu102">

                    <div class="prix">
                    <p><?php echo($datasItemStore["Cout"]);?>€</p>
                    </div>
                
                         <p>
                        </p>
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-number"  data-type="minus" data-field='<?php echo $datasItemStore["Id_article"]; ?>'>
                                    <span class="glyphicon glyphicon-minus"></span>
                                </button>
                            </span>
                                <input type="text" name='<?php echo $datasItemStore["Id_article"]; ?>' class="form-control input-number" value="" min="0" max="100">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field='<?php echo $datasItemStore["Id_article"]; ?>'>
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                            </span>
                         </div>
                         <div class="Panier">
                        <button class="btn btn-primary" type="button" name="Panier" onclick="addtocart({Qty:document.getElementById('<?php echo $datasItemStore['Id_article']; ?>').value, ArticleID:'<?php echo $datasItemStore['Id_article']?>'})">
                        <i class="fas fa-cart-plus"></i>
                        </button>
                
                    </div>
                        <p></p>
                    <br/>
                </div>
                <div class="contenu103">
                    <div id="bouton_bde">
                        <form id="form2">
                         <button type="button" class="btn btn-danger btn-circle" onclick="processRemoveArticle(<?php echo $datasItemStore['Id_article'];?>)">
                            <i class="glyphicon glyphicon-remove" ></i>
                        </button>
                        </form>
                        <form method="post" id="form" action="../store/editArticle.php">
                            <input type="hidden" name="id" value="<?php echo $datasItemStore['Id_article'];?>"/>
                            <button class="btn btn-warning" type="submit" name="edit"><i class="glyphicon glyphicon-cog"></i></button>
                          </form>
                    </div>
                </div>

            </div>