class AddProgrammerUrlToProgrammer < ActiveRecord::Migration
  def change
    add_column :programmers, :website, :string
  end
end
