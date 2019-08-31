


<div class="modal-dialog ">

          <!-- Modal content-->
          <div class="modal-content crate-modal-content">
            <div class="modal-header text-center">
              <h4 class="modal-title">Create a Poll</h4>
            </div>
            <div class="modal-body">
              <form id="pollform" >
                {{ csrf_field() }}
              
              <label>Poll title</label>
              <input type="text" name="title" class='titles form-control'><span class="error error_title"></span><br>
               
              <label>Expiry Date</label>
              <input type="date" name="expiry_date" class='expiry_date form-control'><span class="error error_expiry_date"></span><br>
              
              <label>Options</label>

       
              <input type="text" class="form-control" name="option[]"><span class="error error_option"></span>
              <br>
          
              <input type="text" name="option[]" class="form-control"><span class="error error_option"></span>
              <br>
                
          
              <div class="options">
                
              </div>

              <button type="button" class="btn btn-sm btn-secondary mt-2" onclick="AddOptions()">Add more</button>
            </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button onclick="SaveOptions()" type="button" class="btn btn-info">Create</button>
            </div>
          </div>

        </div>