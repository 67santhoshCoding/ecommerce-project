
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputName1">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $info->name ?? '' }}" id="exampleInputName1" placeholder="Name">
                        </div>
                        <div class="form-group">
                            <label for="">Is Parent</label>
                            <div class="check-box">
                                <input class="form-check" type="checkbox"  name="is_parent" id="is_parent" value="1" @if( (isset( $info->parent_id ) && $info->parent_id == 0 ) || !isset($info->parent_id) ) checked @endif />
                            </div>  
                        </div>
                        
                        <input type="hidden" name="id" value="{{ $info->id ?? '' }}" >
                        <div class="form-group @if( (isset( $info->parent_id ) && $info->parent_id == 0 ) ||!isset($info->parent_id)  ) d-none @endif" id="parentCategoryDiv" >
                            <label for="exampleInputName1">Parent Category</label>
                            <br>
                            <select class="js-example-disabled-results form-select form-select-solid fw-bolder" name="parent_id" id="parent_id">
                                <option value="">Select a Category...</option>
                                @if(isset($category) && !empty($category))
                                @foreach ($category as $key=>$val )
                                    <option value="{{ $val->id }}" @if( (isset( $info->parent_id ) && $info->parent_id == $val->id ) ) selected @endif>{{ $val->name }}</option>
                                @endforeach
                                @endif
                              </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="exampleInputMobile">Category image</label>
                            <div class="field">
                            <input type="file" class="form-control" id="image" name="image" >
                            </div>
                        </div>
                        <div class="form-group" style="">
                            <div class="col-sm-9 field image-area" style="">
                                @if (isset($info->image) && !empty($info->image))
                                <img src="{{ asset('storage/app/'.$info->image) }}"  alt="Preview">
                                <a class="remove-image" onclick="myFunction()" style="display: inline;">&#215;</a>

                               @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputName1">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control" >{{ $info->description ?? '' }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="">Status</label>
                            <div class="check-box">
                                <input type="checkbox" name="status" id="status" @if( (isset( $info->status ) && $info->status == 'published' )  ) checked @endif>
                            </div>  
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="">Is Feature</label>
                            <div class="check-box">
                                <input type="checkbox" name="is_featured" value="1" id="is_featured"  @if( (isset( $info->is_featured ) && $info->is_featured == 'Yes' ) ) checked @endif >
                            </div>  
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="">Sorting Order</label>
                            <input type="text" name="order_by" id="order_by" value="{{ $info->order_by ?? '' }}" class="form-control">
                        </div>
                    </div>
                </div>
                
            