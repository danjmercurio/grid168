class RemoveProgrammerTypeIdFromProgrammer < ActiveRecord::Migration
  def change
    remove_column :programmers, :programmer_type_id
  end
end
