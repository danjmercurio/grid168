class ChangeNotesName < ActiveRecord::Migration
  def change
    remove_column :offers, :notes
    add_column :offers, :offer_note, :text
  end
end
