class AddProgrammerTypeToProgrammers < ActiveRecord::Migration
  def change
    add_column :programmers, :programmer_type_id, :integer
  end
end
