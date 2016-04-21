class AddProgrammerTypeAsStringToProgrammer < ActiveRecord::Migration
  def change
    add_column :programmers, :type, :string
  end
end
